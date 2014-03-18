<?php

class TeacherController extends AppController {

    public $components = array('RequestHandler', 'SchoolInformation');
    public $uses = array('Teacher');

    public function index() {
        $conditions = array();
        if ($this->SchoolInformation->isDepartmentIdAvailable()) {
            $conditions['Teacher.department_id'] = $this->SchoolInformation->isDepartmentIdAvailable();
        }
        $teachers = $this->Teacher->find(
            'all',
            array(
                'recursive' => -1,
                'conditions' => $conditions
            )
        );

        $this->set(array(
            'teachers' => $teachers,
            '_serialize' => array('teachers')
        ));
    }

}
