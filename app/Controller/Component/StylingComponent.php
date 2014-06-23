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
	        $schoolStyle = $controller->Department->getStyleId($controller->SchoolInformation->getDepartmentId());

	        if ($schoolStyle) {
		        $styleId = $schoolStyle;
	        }
        }
        if ($controller->SchoolInformation->isDepartmentIdAvailable()) {
	        $departmentStyle = $controller->Department->getStyleId($controller->SchoolInformation->getDepartmentId());

	        if ($departmentStyle) {
		        $styleId = $departmentStyle;
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