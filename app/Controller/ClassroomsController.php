<?php

App::uses('AppController', 'Controller');

/**
 * Class ClassroomsController
 *
 * @property ScheduleEntry ScheduleEntry
 */
class ClassroomsController extends AppController {

	public $components = array(
		'AutoPermission' => array(
			'mappings' => array(
				'read'   => array('available')
			),
		)
	);

	function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow('available');
	}


	public function available() {
		$classroomAvailableData = $this->Classroom->getAvailableClassrooms(time(), $this->Department->id);

		$available_classrooms = $classroomAvailableData['data'];
		if (!empty($this->request->params['requested'])) {
			return $available_classrooms;
		}

		$this->set(compact('available_classrooms'));
	}

}