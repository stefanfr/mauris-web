<?php

App::uses('AppControler', 'Controller');

/**
 * Class EventsController
 *
 * @property Event Event
 * @property SchoolInformationComponent SchoolInformation
 */
class EventsController extends AppController {

	public $components = array(
		'Paginator' => array(
			'settings' => array(
				'order' => array(
					'Event.start' => 'DESC'
				)
			)
		),
		'TimeAware' => array(
			'end' => false,
		),
		'RequestHandler'
	);

	function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow('overview');
	}


	public function index() {
		$timezone = new DateTimeZone('Europe/Amsterdam');

		$conditions = array();
		if ($this->TimeAware->hasEnd()) {
			$conditions = array(
				'or' => array(
					array (
						'Event.start BETWEEN ? AND ?' => array(
							date('Y-m-d', $this->TimeAware->getStart()),
							date('Y-m-d', $this->TimeAware->getEnd())
						)
					),
					array(
						'Event.end BETWEEN ? AND ?' => array(
							date('Y-m-d', $this->TimeAware->getStart()),
							date('Y-m-d', $this->TimeAware->getEnd())
						)
					)
				)
			);
		} else {
			$conditions['? < Event.start'] = date('Y-m-d', $this->TimeAware->getStart());
		}
		$conditions['and']['or'][] = array(
			'and' => array(
				'Event.school_id IS NULL',
				'Event.department_id IS NULL'
			)
		);
		if ($this->SchoolInformation->isSchoolIdAvailable()) {
			$conditions['and']['or'][] = array(
				'and' => array(
					'Event.school_id' => $this->SchoolInformation->getSchoolId(),
					'Event.department_id IS NULL'
				)
			);
		}
		if ($this->SchoolInformation->isDepartmentIdAvailable()) {
			$conditions['and']['or'][] = array(
				'and' => array(
					'Event.school_id' => $this->SchoolInformation->getSchoolId(),
					'Event.department_id' => $this->SchoolInformation->getDepartmentId()
				)
			);
		}



		//debug($conditions);

		$events = $this->Event->find(
			'all',
			array(
				'conditions' => $conditions,
				'order' => 'Event.start ASC'
			)
		);

		$calendarEvents = array();
		foreach ($events as $entry) {
			$startDate = new DateTime($entry['Event']['start']);
			$endDate = new DateTime($entry['Event']['end']);

			$startDate->setTimezone($timezone);
			$endDate->setTimezone($timezone);

			$event = array(
				'id' => $entry['Event']['id'],
				'title' => $entry['Event']['title'],
				'description' => $entry['Event']['description'],
				'start' => $startDate->format('c'),
				'end' => $endDate->format('c'),
				'allDay' => (bool) $entry['Event']['all_day'],
				'type' => $entry['Event']['type'],
			);

			$calendarEvents[] = $event;
		}

		$this->set(array(
			'events' => $calendarEvents,
			'_serialize' => array('events')
		));
	}

	public function overview() {
		$conditions = array();
		if ($this->TimeAware->hasEnd()) {
			$conditions = array(
				'or' => array(
					array (
						'Event.start BETWEEN ? AND ?' => array(
							date('Y-m-d', $this->TimeAware->getStart()),
							date('Y-m-d', $this->TimeAware->getEnd())
						)
					),
					array(
						'Event.end BETWEEN ? AND ?' => array(
							date('Y-m-d', $this->TimeAware->getStart()),
							date('Y-m-d', $this->TimeAware->getEnd())
						)
					)
				)
			);
		} else {
			$conditions['? < Event.start'] = date('Y-m-d', $this->TimeAware->getStart());
		}
		$conditions['and']['or'][] = array(
			'and' => array(
				'Event.school_id IS NULL',
				'Event.department_id IS NULL'
			)
		);
		if ($this->SchoolInformation->isSchoolIdAvailable()) {
			$conditions['and']['or'][] = array(
				'and' => array(
					'Event.school_id' => $this->SchoolInformation->getSchoolId(),
					'Event.department_id IS NULL'
				)
			);
		}
		if ($this->SchoolInformation->isDepartmentIdAvailable()) {
			$conditions['and']['or'][] = array(
				'and' => array(
					'Event.school_id' => $this->SchoolInformation->getSchoolId(),
					'Event.department_id' => $this->SchoolInformation->getDepartmentId()
				)
			);
		}

		$events = $this->Event->find(
			'all',
			array(
				'conditions' => $conditions,
				'order' => 'Event.start ASC'
			)
		);

		$this->set(compact('events'));
		$this->set('_serialize', array('events'));
	}

	public function manage_index() {
		$readAccessScopes = $this->PermissionCheck->getScopes('event', 'read');
		if (!$readAccessScopes) {
			throw new ForbiddenException();
		}

		$this->Paginator->settings = $this->paginate;
		/**
		 * The latest schedule entries need the shown first
		 */
		$this->Paginator->settings['order']['Event.start'] = 'DESC';

		$conditions = array();
		if (in_array('department', $readAccessScopes)) {
			$conditions['and']['or'][] = array(
				'and' => array(
					'Event.department_id' => $this->Department->id,
				)
			);
		}

		$events = $this->Paginator->paginate('Event', $conditions);

		$this->set(compact('events'));
	}

	public function manage_add() {
		$scopes = $this->PermissionCheck->getScopes('event', 'create');
		if (!$scopes) {
			throw new ForbiddenException();
		}

		if ($this->SchoolInformation->isSchoolIdAvailable()) {
			$organizationConditions = array(
				'id' => $this->SchoolInformation->getSchoolId()
			);
			$departmentConditions = array(
				'school_id' => $this->SchoolInformation->getSchoolId()
			);
		} elseif ($this->SchoolInformation->isDepartmentIdAvailable()) {
			$organizationConditions = array(
				'id' => $this->SchoolInformation->isDepartmentIdAvailable()
			);
			$departmentConditions = array(
				'department_id' => $this->SchoolInformation->getDepartmentId()
			);
		} else {
			$organizationConditions = array();
			$departmentConditions = array();
		}

		$schools = $this->Event->School->find('list', $organizationConditions);
		$departments = $this->Event->Department->find('list', $departmentConditions);

		$this->set(compact('scopes', 'departments', 'schools'));

		if ($this->request->is(array('post', 'put'))) {
			if (
				(!isset($this->request->data['Event']['school_id'])) ||
				(!isset($this->request->data['Event']['department_id'])) ||
				(!in_array($this->request->data['Event']['school_id'], array_keys($schools))) ||
				(!in_array($this->request->data['Event']['department_id'], array_keys($departments)))
			) {
				throw new ForbiddenException();
			}

			$this->Event->create();
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash(__('The event has been added'), 'alert', array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-success'
				));

				$this->redirect(array('action' => 'index'));

				return;
			}

			$this->Session->setFlash(__('Could not add the event'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-danger'
			));
		}
	}

	public function manage_edit($id) {
		$this->Event->id = $id;

		$event = $this->Event->read();
		if (!$event) {
			throw new NotFoundException();
		}

		//region Scope determination
		$scope = 'system';
		if ($event['Event']['department_id'] === $this->SchoolInformation->getDepartmentId()) {
			$scope = 'department';
		}
		//endregion

		$readAccessScopes = $this->PermissionCheck->checkPermission('event', 'update', $scope);
		if (!$readAccessScopes) {
			throw new ForbiddenException();
		}

		$conditions = array(
			'department_id' => $event['Event']['department_id']
		);

		$departments = $this->Event->Department->find('list', ($scope == 'system') ? array() : $conditions);

		$this->set(compact('event', 'departments'));

		if ($this->request->is(array('post', 'put'))) {
			if (!in_array($this->request->data['Event']['department_id'], array_keys($departments))) {
				throw new ForbiddenException();
			}

			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash(__('The event has been changed'), 'alert', array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-success'
				));

				$this->redirect(array('action' => 'index'));

				return;
			}

			$this->Session->setFlash(__('Could not change the event'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-danger'
			));
		}
	}

	public function manage_delete($id) {
		$this->Event->id = $id;

		$event = $this->Event->read();
		if (!$event) {
			throw new NotFoundException();
		}

		//region Scope determination
		$scope = 'system';
		if ($event['Event']['department_id'] === $this->SchoolInformation->getDepartmentId()) {
			$scope = 'department';
		}
		//endregion

		$readAccessScopes = $this->PermissionCheck->checkPermission('event', 'delete', $scope);
		if (!$readAccessScopes) {
			throw new ForbiddenException();
		}

		$this->set(compact('event', 'departments'));

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Event->delete($this->request->data)) {
				$this->Session->setFlash(__('The event has been deleted'), 'alert', array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-success'
				));

				$this->redirect(array('action' => 'index'));

				return;
			}

			$this->Session->setFlash(__('Could not delete the event'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-danger'
			));
		}
	}

}