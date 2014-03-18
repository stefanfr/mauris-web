<?php

class SchoolInformationComponent extends Component {
    
    private $school;
    private $department;

    public function startup(\Controller $controller) {
        $department = $controller->Department->findByHostname($_SERVER['HTTP_HOST']);
        
        if (!empty($department)) {
            $this->department = (int) $department['Department']['id'];
            $this->school = (int) $department['BelongingToSchool']['id'];
        }
        
        if (isset($controller->request->query['school'])) {
            $this->school = (int) $controller->request->query['school'];
        }
        if (isset($controller->request->query['department'])) {
            $this->department = (int) $controller->request->query['department'];
        }
    }
    
    public function isSchoolIdAvailable() {
        return !empty($this->school);
    }
    
    public function getSchoolId() {
        return $this->school;
    }
    
    public function isDepartmentIdAvailable() {
        return !empty($this->department);
    }
    
    public function getDepartmentId() {
        return $this->department;
    }

    
}