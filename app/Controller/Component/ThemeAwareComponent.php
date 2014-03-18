<?php

class ThemeAwareComponent extends Component {
    
    public function startup(\Controller $controller) {
        if (isset($controller->request->query['theme'])) {
            $controller->theme = $controller->request->query['theme'];
        }
    }
   
}