<?php

App::uses('AppController', 'Controller');

class ManageAppController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->PermissionCheck->settings['global_lookup'] = array('manage');
        
        if (!$this->Auth->user()) {
            throw new UnauthorizedException();
        }
        
        $hasAccess = $this->PermissionCheck->checkPermission('manage', 'read');
        if (!$hasAccess) {
            throw new ForbiddenException();
        }
    }
    
}