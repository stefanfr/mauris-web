<?php

class SchoolInformationComponent extends Component {
    
    public $components = array('DataFilter');

    private $dataFilter;
    private $school;
    private $department;
    
    public function initialize(\Controller $controller) {
        DebugTimer::start('component-school-information-startup', __('Processing school information'));
        
        if (!isset($controller->DataFilter)) {
            $controller->DataFilter = $controller->Components->load('DataFilter');
        }
        
        $this->dataFilter = $controller->DataFilter;
        
        $controller->DataFilter->addCustomFilter('school');
        $controller->DataFilter->addCustomFilter('department');
        
        $hostname = $controller->request->host();
        
        $department = $controller->Department->findByHostname($hostname);
        $school = $controller->School->find('first', array(
            'recursive' => 2,
            'conditions' => array(
                'hostname' => $hostname 
            )
        ));
        
        if (!empty($school)) {
            $controller->DataFilter->setCustomFilter('school', (int) $school['School']['id']);
        }
        
        if (!empty($department)) {
            $controller->DataFilter->setCustomFilter('school', (int) $department['BelongingToSchool']['id']);
            $controller->DataFilter->setCustomFilter('department', (int) $department['Department']['id']);
        }
        
        if (isset($controller->request->query['school'])) {
            $controller->DataFilter->setCustomFilter('school', (int) $controller->request->query['school']);
        }
        if (isset($controller->request->query['department'])) {
            $controller->DataFilter->setCustomFilter('department', (int) $controller->request->query['department']);
        }
        
        if ($this->isSchoolIdAvailable()) {
            $controller->School->id = $this->getSchoolId();
        }
        
        if ($this->isDepartmentIdAvailable()) {
            $controller->Department->id = $this->getDepartmentId();
        }
        
        DebugTimer::stop('component-school-information-startup');
    }
    
    public function beforeRender(\Controller $controller) {
        DebugTimer::start('component-school-information-before-render', __('Render preparation with school information '));
        
        if ($this->isSchoolIdAvailable()) {
            $school = $controller->School->find(
                'first',
                array(
                    'conditions' => array(
                        'School.id' => $this->getSchoolId()
                    ),
                    'recursive' => 0
                )
            );
            
            $controller->set('school_id', $this->getSchoolId());
            $controller->set('school_name', $school['School']['name']);
        }
        
        if ($this->isDepartmentIdAvailable()) {
            $department = $controller->Department->find(
                'first',
                array(
                    'conditions' => array(
                        'Department.id' => $this->getDepartmentId()
                    ),
                    'recursive' => 0
                )
            );
            
            $controller->set('department_id', $this->getDepartmentId());
            $controller->set('department_name', $department['Department']['name']);
        }
        
        DebugTimer::stop('component-school-information-before-render');
    }
    
    public function isSchoolIdAvailable() {
        return $this->dataFilter->hasCustomFilter('school');
    }
    
    public function getSchoolId() {
        return $this->dataFilter->getCustomFilter('school');
    }
    
    public function isDepartmentIdAvailable() {
        return $this->dataFilter->hasCustomFilter('department');
    }
    
    public function getDepartmentId() {
        return $this->dataFilter->getCustomFilter('department');
    }

    
}