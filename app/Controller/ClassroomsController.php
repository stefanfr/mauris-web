<?php

App::uses('AppController', 'Controller');

/**
 * Class ClassroomsController
 *
 * @property ScheduleEntry ScheduleEntry
 * @property Classroom Classroom
 */
class ClassroomsController extends AppController {

	public $components = array(
		'AutoPermission' => array(
			'mappings' => array(
				'read'   => array('available')
			),
		),
		'Paginator' => array(
			'limit' => 5
		)
	);

	function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow('available');
	}


	public function available() {
		$this->Paginator->settings['departmnet'] = $this->SchoolInformation->getDepartmentId();
		$this->Paginator->settings['scopes'] = array('department');
		$this->Paginator->settings['recursive'] = 2;
		$available_classrooms = $this->Paginator->paginate('Classroom', $this->Classroom->availableClassroomConditions($this->SchoolInformation->getDepartmentId()));

		if (!empty($this->request->params['requested'])) {
			return $available_classrooms;
		}

		$this->set(compact('available_classrooms'));
	}

}