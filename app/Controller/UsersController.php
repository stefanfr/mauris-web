<?php

class UsersController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        // Allow users to register and logout.
        $this->Auth->allow('logout', 'register', 'install');    
    }

    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function register() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('controller' => 'profile', 'action' => 'index'));
            }
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.')
            );
        }
    }
    
    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.')
            );
        }
    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.')
            );
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        $this->request->onlyAllow('post');

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirect());
            }
            $this->Session->setFlash(__('Invalid username or password, try again'), 'alert-box', array('class'=>'alert-info'));
        }
    }


    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
    
    public function install(){     
        /*if($this->Acl->Aro->findByAlias("Admin")){ 
            $this->redirect('/'); 
        } */
        /*$aro = new aro(); 

        $aro->create(); 
        $aro->save(array( 
            'model' => 'User', 
            'foreign_key' => null, 
            'parent_id' => null, 
            'alias' => 'Super'
        )); 

        $aro->create(); 
        $aro->save(array( 
            'model' => 'User', 
            'foreign_key' => null, 
            'parent_id' => null, 
            'alias' => 'Admin'
        )); 

        $aro->create(); 
        $aro->save(array( 
            'model' => 'User', 
            'foreign_key' => null, 
            'parent_id' => null, 
            'alias' => 'User'
        )); 

        $aro->create(); 
        $aro->save(array( 
            'model' => 'User', 
            'foreign_key' => null, 
            'parent_id' => null, 
            'alias' => 'Suspended'
        )); 

        $aco = new Aco(); 
        $aco->create(); 
        $aco->save(array( 
            'model' => 'User', 
            'foreign_key' => null, 
            'parent_id' => null, 
            'alias' => 'User'
        )); 

        $aco->create(); 
        $aco->save(array( 
           'model' => 'Post', 
           'foreign_key' => null, 
           'parent_id' => null, 
           'alias' => 'Post'
        )); */

        /*$this->Acl->allow(
            'full-administrator',
            array(
                'preference' => 9999,
                'permission' => array(
                    'school',
                    'department'
                )
            ),
            '*'
        );*/
        //$this->Acl->allow('teacher', 'post');
        //$this->Acl->allow('student', 'comment', array('create', ));
        /*$this->Acl->allow('Super', 'Post', '*'); 
        $this->Acl->allow('Super', 'User', '*'); 
        $this->Acl->allow('Admin', 'Post', '*'); 
        $this->Acl->allow('User', 'Post', array('create')); */
        
        /*var_dump($this->Acl->check(
            'role::full-administrator',
            array(
                'permission' => 'post',
                'school_id' => 1,
                'department_id' => 1,
            ),
            'create'
        ));
        var_dump($this->Acl->check(
            'role::student',
            array(
                'permission' => 'post',
                'school_id' => 1,
                'department_id' => 1,
            ),
            'create'
        ));
        var_dump($this->Acl->check(
            'role::teacher',
            array(
                'permission' => 'post',
                'school_id' => 1,
                'department_id' => 1,
            ),
            'create'
        ));
        var_dump($this->Acl->check(
            'user::marlinc',
            array(
                'permission' => 'post',
                'school_id' => 1,
                'department_id' => 1,
            ),
            'create'
        ));*/
        //var_dump($this->Acl->check('role::anonymous', 'post', 'read'));
        //var_dump($this->Acl->check('role::anonymous', 'news', 'read'));
        echo 'Test?' . PHP_EOL;
        var_dump($this->Acl->check('user::BramKoolen', 'comment', 'create'));
        var_dump($this->Acl->check('user::BramKoolen', array('permission' => 'comment', 'school_id' => 1, 'department_id' => 1), 'create'));
        var_dump($this->Acl->check('user::BramKoolen', array('permission' => 'comment', 'school_id' => 1, 'department_id' => 2), 'create'));
        var_dump($this->Acl->check('user::BramKoolen', array('permission' => 'comment', 'school_id' => 2, 'department_id' => 1), 'create'));
        var_dump($this->Acl->check('user::BramKoolen', array('permission' => 'comment', 'school_id' => 2, 'department_id' => 2), 'create'));
        var_dump($this->Acl->check('user::BramKoolen', array('permission' => 'comment', 'school_id' => 1), 'create'));
        //var_dump($this->Acl->check('user::BramKoolen', array('permission' => 'comment', 'department_id' => 1), 'create'));
        var_dump($this->Acl->check('user::BramKoolen', array('permission' => 'comment'), 'create'));
        
        
    }
    
}