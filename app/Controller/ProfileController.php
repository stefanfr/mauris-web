<?php
class ProfileController extends AppController {

    public $uses = array('Auth', 'User');
        
    public function view($id = null) {    
        $this->User->recursive = 2;
        $this->User->id = ($id) ? $id : $this->Auth->user('id');
        
        $this->set(
            'fullname',
            implode(
                ' ', array(
                    $this->User->field('firstname'),
                    $this->User->field('middlename'),
                    $this->User->field('surname'),
                )
            )
        );
        $this->set(
            'nickname', $this->User->field('nickname')
        );
        $this->set(
            'system_email', $this->User->field('system_email')
        );
        
        $this->set('user', $this->User->read());
    }
    
}
