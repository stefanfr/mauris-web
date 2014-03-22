<?php

class LanguageAwareComponent extends Component {

    public function startup(\Controller $controller) {
        if (isset($controller->request->query['language'])) {
            Configure::write('Config.language', $controller->request->query['language']);
        }
    }
    
}