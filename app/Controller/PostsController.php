<?php

App::uses('AppController', 'Controller');

class PostsController extends AppController {
	
    public $components = array('Session', 'Paginator', 'RequestHandler');
    
    public $uses = array('Post', 'Comment', 'User');
    
    public $paginate = array(
        'limit' => 3,
        'order' => array(
            'Post.created' => 'DESC'
        )
    );
    
    public function index() {
        $allowedScopes = $this->PermissionCheck->getScopes('post', 'read');

        if (empty($allowedScopes)) {
            throw new ForbiddenException();
        }
        
        $this->set('can_post', $this->PermissionCheck->checkPermission('post', 'create'));

		$this->Paginator->settings = $this->paginate;

		$Selector = $this->SchoolInformation->getSelector();

		$conditions = array();
		$conditions['and']['Post.published'] = true;
        if (!in_array('school', $allowedScopes)) {
            $Selector->unsetOrganization();
        }
        if (!in_array('department', $allowedScopes)) {
			$Selector->unsetDepartment();
        }

		$this->Paginator->settings['match'] = $Selector;

        $this->set(
            'posts',
            $this->Paginator->paginate(
                'Post',
                $conditions
            )
        );

        $this->set('title_for_layout', __('News'));
    }

    public function view($id = null, $slug = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $this->Post->recursive = 2;
        $this->Post->id = $id;
        $post = $this->Post->read();
        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }
        
        if (Inflector::slug($post['Post']['title']) != $slug) {
            return $this->redirect(array($id, Inflector::slug($post['Post']['title'])), 301);
        }

        $scope = null;
        //print_r($post);
        if ($post['PostedBy']['id'] == $this->Auth->user('id')) {
            $scope = 'own';
        } else {
            if ((!empty($post['Post']['school_id'])) && ($post['Post']['school_id'] == $this->SchoolInformation->isSchoolIdAvailable())) {
                $scope = 'school';
                if ((!empty($post['Post']['department_id'])) && ($post['Post']['department_id'] == $this->SchoolInformation->isDepartmentIdAvailable())) {
                    $scope = 'department';
                }
            } else {
                $scope = 'system';
            }
        }
        
        debug($scope);
        
        //debug($this->User->getUserDetails($this->Auth->user('id')));
        
        $this->set('post', $post);
        $this->set('comments', $this->Comment->getPostComments($id));

        $this->set('can_comment', $this->PermissionCheck->checkPermission('comment', 'create', $scope));
        $this->set('can_view_comments', $this->PermissionCheck->checkPermission('comment', 'read', $scope));

        $this->set('title_for_layout', $post['Post']['title']);
    }

    public function add() {
        $allowedScopes = $this->PermissionCheck->getScopes('post', 'create');
        $this->set('allowed_scopes', $allowedScopes);
        if (empty($allowedScopes)) {
            throw new ForbiddenException();
        }
        if ($this->request->is('post')) {
            $this->request->data['Post']['user_id'] = $this->Auth->user('id');
            $this->request->data['Post']['created'] = date('Y-m-d H:i:s');
            
            if (!in_array($this->request->data['Post']['scope'], $allowedScopes)) {
                throw new ForbiddenException();
            }
            
            if ($this->request->data['Post']['scope'] == 'school') {
                $this->request->data['Post']['school_id'] = $this->School->id;
            }
            if ($this->request->data['Post']['scope'] == 'department') {
                $this->request->data['Post']['school_id'] = $this->School->id;
                $this->request->data['Post']['department_id'] = $this->Department->id;
            }
            
            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
                $this->Session->setFlash(__('Your post has been saved.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
				
                return $this->redirect(array('action' => 'index'));
            }
            
            $this->Session->setFlash(__('Unable to add your post.'), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-danger'
            ));
        }
    }
    
    public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid post'));
		}

		$post = $this->Post->findById($id);
		if (!$post) {
			throw new NotFoundException(__('Invalid post'));
		}

		if ($this->request->is(array('post', 'put'))) {
			$this->Post->id = $id;
			if ($this->Post->save($this->request->data)) {
				
				$this->Session->setFlash(__('Your post has been updated.'), 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-success'
				));
					
				return $this->redirect(array('action' => 'index'));
			}
            
            $this->Session->setFlash(__('Unable to update your post.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-danger'
			));
		}

		if (!$this->request->data) {
			$this->request->data = $post;
		}
	}
	
	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}

		if ($this->Post->delete($id)) {
			
			$this->Session->setFlash(__('Your post has been deleted.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-danger'
			));
					
			return $this->redirect(array('action' => 'index'));
		}
	}
}
