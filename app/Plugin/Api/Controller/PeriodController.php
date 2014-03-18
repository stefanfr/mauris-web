<?php
class PeriodController extends AppController {

    public $components = array('RequestHandler', 'SchoolInformation');
    public $uses = array('Period');

    public function index() {
        $conditions = array();
        if ($this->SchoolInformation->isDepartmentIdAvailable()) {
            $conditions['Period.department_id'] = $this->SchoolInformation->isDepartmentIdAvailable();
        }
        $periods = $this->Period->find(
            'all',
            array(
                'recursive' => -1,
                'conditions' => $conditions,
                'order' => array(
                    'period ASC'
                )
            )
        );
        $this->set(array(
            'periods' => $periods,
            '_serialize' => array('periods')
        ));
    }
    
}