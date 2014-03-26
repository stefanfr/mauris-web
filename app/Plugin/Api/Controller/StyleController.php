<?php

class StyleController extends AppController {

    public $components = array(
        'RequestHandler', 'TimeAware', 'SchoolInformation', 'Styling'
    );

    public function index() {
        $this->set(array(
            '_serialize' => array('style')
        ));
    }
    
}
