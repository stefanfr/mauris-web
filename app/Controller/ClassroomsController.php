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
		)
	);

	function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow('available');
	}


	public function available() {
		$available_classrooms = $this->Classroom->getAvailableClassrooms($this->Department->id);

		if (!empty($this->request->params['requested'])) {
			return $available_classrooms;
		}

		$this->set(compact('available_classrooms'));
	}

}