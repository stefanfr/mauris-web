<?php

class StylingComponent extends Component {
    
    public function startup(\Controller $controller) {
        if (!isset($controller->SchoolInformation)) {
            $controller->SchoolInformation = $controller->Components->load('SchoolInformation');
        }
    }
    
    public function beforeRender(\Controller $controller) {
        $styleId = null;
        
        DebugTimer::start('component-styling', __('Render preparation with organization style'));
        
        if ($controller->SchoolInformation->isSchoolIdAvailable()) {
            $school = $controller->School->find(
                'first',
                array(
                    'conditions' => array(
                        'School.id' => $controller->SchoolInformation->getSchoolId()
                    )
                )
            );
            
            $styleId = $school['UsesStyle']['id'];
        }
        if ($controller->SchoolInformation->isDepartmentIdAvailable()) {
            $department = $controller->Department->find(
                'first',
                array(
                    'conditions' => array(
                        'Department.id' => $controller->SchoolInformation->getDepartmentId()
                    )
                )
            );
            
            $styleId = $department['UsesStyle']['id'];
        }
        
        if ($styleId) {
            $style = $controller->Style->getStyle($styleId);
            
            $controller->set(compact('style'));
        }
        
        DebugTimer::stop('component-styling');
    }
    
}