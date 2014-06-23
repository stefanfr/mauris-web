<?php

class StylingComponent extends Component {
    
    private $_style;
    
    public function startup(\Controller $controller) {
        if (!isset($controller->SchoolInformation)) {
            $controller->SchoolInformation = $controller->Components->load('SchoolInformation');
        }
        
        $styleId = null;
        
        DebugTimer::start('component-styling', __('Render preparation with organization style'));
        
        if ($controller->SchoolInformation->isSchoolIdAvailable()) {
            $school = $controller->School->find(
                'first',
                array(
                    'conditions' => array(
                        'School.id' => $controller->SchoolInformation->getSchoolId()
                    ),
	                'recursive' => 0
                )
            );

	        if ($school['UsesStyle']['id']) {
		        $styleId = $school['UsesStyle']['id'];
	        }
        }
        if ($controller->SchoolInformation->isDepartmentIdAvailable()) {
            $department = $controller->Department->find(
                'first',
                array(
                    'conditions' => array(
                        'Department.id' => $controller->SchoolInformation->getDepartmentId()
                    ),
                    'recursive' => 0
                )
            );

	        if ($department['UsesStyle']['id']) {
		        $styleId = $department['UsesStyle']['id'];
	        }
        }
        
        if ($styleId) {
            $this->_style = $controller->Style->getStyle($styleId);

            $controller->set(
                array(
                    'style' => $this->getStyle()
                )
            );
        }
        
        DebugTimer::stop('component-styling');
    }
    
    public function getStyle() {
        return $this->_style;
    }
    
}