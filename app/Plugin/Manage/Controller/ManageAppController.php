<?php

class ManageAppController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        
        if (!$this->Auth->user()) {
            throw new UnauthorizedException();
        }
        
        if ($this->Auth->user()) {
            $requester = 'user::' . $this->Auth->user('id');
        } else {
            $requester = 'role::anonymous';
        }
        
        $hasAccess = $this->Acl->check(
            $requester, array('permission' => 'manage', 'school_id' => $this->School->id, 'department_id' => $this->Department->id), 'read'
        );
        if (!$hasAccess) {
            throw new ForbiddenException();
        }
    }
    
}