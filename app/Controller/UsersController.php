<?php

App::uses('AppController', 'Controller');

/**
 * Class UsersController
 *
 * @property User User
 */
class UsersController extends AppController {

	public $components = array(
		'Paginator' => array(
			'settings' => array(
				'limit' => 5
			)
		)
	);

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
            throw new NotFoundException(__('Could not find this user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

	public function profile($id = null) {
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

		$this->set('user_account', $this->User->read());
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
	            $this->redirect($this->Auth->redirectUrl());

	            return;
            }

	        $this->Session->setFlash(__('Invalid username or password, try again'), 'alert', array(
		        'plugin' => 'BoostCake',
		        'class'  => 'alert-danger'
	        ));
        }
    }


    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

	public function admin_index() {
		$hasPermission = $this->PermissionCheck->checkPermission('user', 'read', 'system');
		if (!$hasPermission) {
			throw new ForbiddenException();
		}

		$this->set('users', $this->Paginator->paginate('User'));
	}

	public function admin_edit($id) {
		$this->User->id = $id;
		$user = $this->User->read();
		if (empty($user)) {
			throw new NotFoundException();
		}

		if (!$this->request->data) {
			$this->request->data = $user;
		}

		if ($this->request->is(array('post', 'put'))) {
			$this->User->id = $id;
			if ($this->User->save($this->request->data)) {
				Cache::clearGroup('users');

				$this->Session->setFlash(__('The user has been changed.'), 'alert', array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-success'
				));

				return $this->redirect(array('action' => 'index'));
			}

			$this->Session->setFlash(__('Could not change the user'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-danger'
			));
		}

		$this->set(compact('user'));
	}

	public function admin_delete($id) {
		$this->User->id = $id;
		$user = $this->User->read();
		if (empty($user)) {
			throw new NotFoundException();
		}

		$this->User->id = $id;
		if ($this->User->delete()) {
			Cache::clearGroup('users');

			$this->Session->setFlash(__('The user has been removed.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-success'
			));

			return $this->redirect(array('action' => 'index'));
		}

		$this->Session->setFlash(__('Could not remove the user'), 'alert', array(
			'plugin' => 'BoostCake',
			'class'  => 'alert-danger'
		));
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