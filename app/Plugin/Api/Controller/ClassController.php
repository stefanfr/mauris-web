<?php
class ClassController extends AppController {

    public $components = array('RequestHandler');
    public $uses = array('AClass');

    public function index() {
        $classes = $this->AClass->find(
            'all',
            array(
                'recursive' => -1,
                'conditions' => array(
                    'department_id' => $this->request->query['department']
                )
            )
        );
        $this->set(array(
            'classes' => $classes,
            '_serialize' => array('classes')
        ));
    }

}
