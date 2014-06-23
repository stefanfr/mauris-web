<?php

class LanguageAwareComponent extends Component {

    public function startup(\Controller $controller) {
        $language = null;
        
        DebugTimer::start('component-language-awareness', __('Processing organization language'));
        if (isset($controller->request->query['language'])) {
            $language = $controller->request->query['language'];
        }
        
        if (!$language) {
            if ($controller->SchoolInformation->isSchoolIdAvailable()) {
	            $schoolLanguage = $controller->School->getLanguageId(
		            $controller->SchoolInformation->getSchoolId()
	            );

	            if ($schoolLanguage) {
		            $language = $schoolLanguage;
	            }
            }

            if ($controller->SchoolInformation->isDepartmentIdAvailable()) {
                $departmentLanguage = $controller->Department->getLanguageId(
	                $controller->SchoolInformation->getDepartmentId()
                );

                if ($departmentLanguage) {
                    $language = $departmentLanguage;
                }
            }
        }
        
        if ($language) {
            if (!$controller->Session->check('Config.language')) {
                Configure::write('Config.language', $language);
            }
        }
        
        DebugTimer::stop('component-language-awareness');
    }
    
}