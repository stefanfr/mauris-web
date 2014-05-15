<?php

App::uses('CakeEmail', 'Network/Email');

/**
 * Class OrganizationsController
 *
 * @property School School
 */
class OrganizationsController extends AppController {

	public $components = array(
		'Paginator' => array(
			'settings' => array(
				'limit' => 5,
				'order' => array(
					'School.name ASC',
				)
			)
		),
		'Security'
	);
	public $uses       = array('School');

	public function beforeFilter() {
		parent::beforeFilter();

		$this->PermissionCheck->settings['global_lookup'][] = 'organization';
	}

	public function website_index() {
		$organizations = $this->Paginator->paginate('School');

		$this->set('organizations', $organizations);
	}

	public function manage_index() {
		if ($this->SchoolInformation->isSchoolIdAvailable()) {
			return $this->redirect(array('action' => 'edit', $this->SchoolInformation->getSchoolId()));
		}
	}

	public function manage_edit($id) {
		$this->School->id = $id;

		// If no organization data has been found return a 404
		if (!$organization = $this->School->read()) {
			throw new NotFoundException(__('Could not find that organization'));
		}

		if ($organization['School']['id'] == $this->SchoolInformation->getSchoolId()) {
			$scope = 'school';
		} else {
			$scope = 'system';
		}

		// Check whenever the current logged in entity has the update
		// permission to organizations.
		if (!$this->PermissionCheck->checkPermission('organization', 'update', $scope)) {
			// Throw a 403 because the user doesn't have the appropriate
			// permissions
			throw new ForbiddenException();
		}

		$this->set('hostname_editable', $this->PermissionCheck->checkPermission('hostname', 'update', $scope));

		// If no data has been entered in the form, pre-populate it with the
		// data in the database
		if (!$this->request->data) {
			$this->request->data = $organization;
		}

		$conditions = array();
		$conditions['or']['UsesStyle.school_id'][] = $this->SchoolInformation->getSchoolId();
		$conditions['or'][] = 'UsesStyle.school_id IS NULL';

		$styles = $this->School->UsesStyle->find(
			'list', array(
				'fields'     => array('id', 'title', 'UsedBySchool.name'),
				'recursive'  => 2,
				'conditions' => $conditions,
			)
		);
		$languages = $this->School->UsesLanguage->find('list');

		if ($this->request->is(array('post', 'put'))) {
			if ($this->School->save($this->request->data)) {
				Cache::clearGroup('organization');

				$this->Session->setFlash(__('The organization has been changed'), 'alert', array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-success'
				));

				if ($this->Auth->user('system_email') != '') {
					$email = new CakeEmail();
					//$email->config('debug');
					$email->config('default');
					$email->emailFormat('both');
					$email->addTo($this->Auth->user('system_email'));
					$email->template('Manage.organization_change');
					$email->viewVars(array_merge(
						array(
							'original' => $organization,
							'current'  => $this->request->data,
							'styles'   => call_user_func_array('array_replace', $styles)
						),
						compact('organization', 'languages')
					));
					$response = $email->send();
				}

				return $this->redirect(array('action' => 'index'));
			}

			$this->Session->setFlash(__('Could not change the organization'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-danger'
			));
		}
		$this->set(compact('organization', 'styles', 'languages'));
	}

	public function admin_index() {
		if (!$this->PermissionCheck->checkPermission('organization', 'read', 'system')) {
			throw new ForbiddenException();
		}

		$this->set('organizations', $this->Paginator->paginate('School'));
	}

	public function admin_add() {
		if (!$this->PermissionCheck->checkPermission('organization', 'create', 'system')) {
			throw new ForbiddenException();
		}

		$styles = $this->School->UsesStyle->find('list', array(
			'fields'     => array('id', 'title'),
			'recursive'  => 2,
			'conditions' => array(
				'UsesStyle.school_id IS NULL'
			),
		));
		$languages = $this->School->UsesLanguage->find('list');

		$this->set(compact('styles', 'languages'));

		if ($this->request->is(array('post', 'put'))) {
			$this->School->create();
			if ($this->School->save($this->request->data)) {
				Cache::clearGroup('organization');

				$this->Session->setFlash(__('The organization has been created'), 'alert', array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-success'
				));

				$this->redirect(array('action' => 'edit', $this->School->id));

				return;
			}

			$this->Session->setFlash(__('Could not create the organization'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-danger'
			));
		}
	}

	public function admin_edit($id) {
		$this->School->id = $id;

		if (!$this->PermissionCheck->checkPermission('organization', 'update', 'system')) {
			throw new ForbiddenException();
		}

		$organization = $this->School->read();
		if (empty($organization)) {
			throw new NotFoundException();
		}

		if (empty($this->request->data)) {
			$this->request->data = $organization;
		}

		$styles = $this->School->UsesStyle->find('list', array(
			'fields'     => array('id', 'title', 'UsedBySchool.name'),
			'recursive'  => 2,
			'conditions' => array(
				'or' => array(
					'UsesStyle.school_id' => $organization['School']['id'],
					'UsesStyle.school_id IS NULL'
				)
			),
		));
		$languages = $this->School->UsesLanguage->find('list');

		$this->set(compact('organization', 'styles', 'languages'));

		if ($this->request->is(array('post', 'put'))) {
			if ($this->School->save($this->request->data)) {
				Cache::clearGroup('organization');

				$this->Session->setFlash(__('The organization has been changed'), 'alert', array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-success'
				));

				if ($this->Auth->user('system_email') != '') {
					$email = new CakeEmail();
					$email->config('default');
					$email->emailFormat('both');
					$email->addTo($this->Auth->user('system_email'));
					$email->template('organization_change');
					$email->viewVars(array_merge(
						array(
							'original' => $organization,
							'current'  => $this->request->data,
							'styles'   => call_user_func_array('array_replace', $styles)
						),
						compact('organization', 'languages')
					));
					$email->send();
				}

				return;
			}

			$this->Session->setFlash(__('Could not change the organization'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-danger'
			));
		}
	}

	public function admin_delete($id) {
		$this->School->id = $id;

		if (!$this->PermissionCheck->checkPermission('organization', 'delete', 'system')) {
			throw new ForbiddenException();
		}

		$organization = $this->School->read();
		if (empty($organization)) {
			throw new NotFoundException();
		}

		$this->set(compact('organization'));

		if ($this->request->is(array('post', 'delete'))) {
			if ($this->School->delete()) {
				Cache::clearGroup('organization');

				$this->Session->setFlash(__('The organization has been removed'), 'alert', array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-success'
				));

				/*
				 * The organization has been removed so its no longer possible to go the the organization's edit page.
				 * This is to make sure the user gets redirected to the index.
				 */
				$this->redirect(array('action' => 'index'));

				return;
			}

			$this->Session->setFlash(__('Could not remove the organization'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-danger'
			));
		}
	}

}