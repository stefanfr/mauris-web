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
                $school = $controller->School->find(
                    'first',
                    array(
                        'conditions' => array(
                            'School.id' => $controller->SchoolInformation->getSchoolId()
                        ),
                        'recursive' => 0
                    )
                );

                $language = $school['UsesLanguage']['code'];
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

                if ($department['UsesLanguage']['code']) {
                    $language = $department['UsesLanguage']['code'];
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