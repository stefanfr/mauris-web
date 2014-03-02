<?php
class PostsController extends AppController {
	
    public $components = array('Session', 'Paginator');
    
    public $uses = array('Post', 'Comment', 'User');
    
    public $paginate = array(
        'limit' => 3,
        'order' => array(
            'Post.created' => 'DESC'
        )
    );
    
    public function index() {
        if ($this->Auth->user()) {
            $requester = 'user::' . $this->Auth->user('id');
        } else {
            $requester = 'role::anonymous';
        }
        $allowedScopes = $this->Acl->check(
            $requester, array('permission' => 'post', 'school_id' => $this->School->id, 'department_id' => $this->Department->id), 'read'
        );
        debug($allowedScopes);
        if (empty($allowedScopes)) {
            throw new ForbiddenException();
        }
        $this->Paginator->settings = $this->paginate;
        
        $conditions = array();
        $conditions['and']['Post.published'] = true; 
        if (in_array('system', $allowedScopes)) {
            $conditions['and']['or'][] = array(
                'and' => array(
                    'Post.school_id IS NULL',
                    'Post.department_id IS NULL'
                )
            );
        }
        if (in_array('school', $allowedScopes)) {
            $conditions['and']['or'][] = array(
                'and' => array(
                    'Post.school_id' => $this->School->id,
                    'Post.department_id IS NULL'
                )
            );
        }
        if (in_array('department', $allowedScopes)) {
            $conditions['and']['or'][] = array(
                'and' => array(
                    'Post.school_id' => $this->School->id,
                    'Post.department_id' => $this->Department->id
                )
            );
        }
        if ((in_array('own', $allowedScopes)) && ($this->Auth->user())) {
            $conditions['and']['or'][] = array(
                'and' => array(
                    'Post.user_id' => $this->Auth->user('id'),
                    'Post.school_id' => $this->School->id,
                    array(
                        'or' => array(
                            'Post.department_id' => $this->Department->id,
                            'Post.department_id IS NULL'
                        )
                    )
                )
            );
        }
        
        $this->set(
            'posts',
            $this->Paginator->paginate(
                'Post',
                $conditions
            )
        );

        $this->set('title_for_layout', __('News'));
    }

    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $this->Post->recursive = 2;
        $this->Post->id = $id;
        $post = $this->Post->read();
        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }
        
        $scope = null;
        //print_r($post);
        if ($post['PostedBy']['id'] == $this->Auth->user('id')) {
            $scope = 'own';
        } elseif ((empty($post['Post']['school_id'])) && (empty($post['Post']['department_id']))) {
            $scope = 'system';
        }
        
        debug($scope);
        
        //debug($this->User->getUserDetails($this->Auth->user('id')));
        
        $this->set('post', $post);
        $this->set('comments', $this->Comment->getPostComments($id));
        
        if ($this->Auth->user()) {
            $requester = 'user::' . $this->Auth->user('id');
        } else {
            $requester = 'role::anonymous';
        }
        $this->set('can_comment', $this->Acl->check(
            $requester, array('scope' => $scope, 'permission' => 'comment', 'school_id' => $post['Post']['school_id'], 'department_id' => $post['Post']['department_id']), 'create'
        ));
        $this->set('can_view_comments', $this->Acl->check(
            $requester, array('scope' => $scope, 'permission' => 'comment', 'school_id' => $post['Post']['school_id'], 'department_id' => $post['Post']['department_id']), 'read'
        ));

        $this->set('title_for_layout', $post['Post']['title']);
    }

    public function add() {
        if ($this->Auth->user()) {
            $requester = 'user::' . $this->Auth->user('id');
        } else {
            $requester = 'role::anonymous';
        }
        $allowedScopes = $this->Acl->check(
            $requester, array('permission' => 'post', 'school_id' => $this->School->id, 'department_id' => $this->Department->id), 'create'
        );
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
