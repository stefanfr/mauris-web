<?php

/**
 * Class TeacherController
 *
 * @property Teacher Teacher
 */
class TeachersController extends AppController {

	public $components = array(
		'RequestHandler', 'AutoPermission'
	);

	function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow('absent');
	}


	public function view($id) {
        $this->Teacher->id = $id;
        $this->Teacher->recursive = 2;
        
        $teacher = $this->Teacher->read();
        if (!$teacher) {
            throw new NotFoundException(__('Could not find this teacher'));
        }
        
        $this->set(
            'title_for_layout',
            ($teacher['Teacher']['name']) ? $teacher['Teacher']['name'] : $teacher['Teacher']['abbreviation']
        );
        $this->set('teacher', $teacher);
    }

	public function absent() {
		$absent_teachers = $this->Teacher->AbsenceReport->getAbsentTeachers(
			time(), strtotime('+7 days', time()), $this->Department->id
		);

		if (!empty($this->request->params['requested'])) {
			return $absent_teachers;
		}

		$this->set(compact('absent_teachers'));
	}
    
}