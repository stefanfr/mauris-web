<?php
class ClassController extends AppController {

    public $components = array('RequestHandler', 'SchoolInformation');
    public $uses = array('AClass');

    public function index() {
        $conditions = array();
        if ($this->SchoolInformation->isDepartmentIdAvailable()) {
            $conditions['AClass.department_id'] = $this->SchoolInformation->isDepartmentIdAvailable();
        }
        $classes = $this->AClass->find(
            'all',
            array(
                'recursive' => -1,
                'conditions' => $conditions
            )
        );
        $this->set(array(
            'classes' => $classes,
            '_serialize' => array('classes')
        ));
    }

}
