<?php

App::uses('AppController', 'Controller');

/**
 * Class CommentController
 *
 * @property Comment Comment
 */
class CommentController extends AppController {

	public $components = array(
		'Paginator' => array(
			'settings' => array(
				'order' => array(
					'Comment.created' => 'DESC'
				),
				'limit' => 5
			)
		)
	);

    public $uses = array('Comment', 'Post', 'User');

	function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow('latest');
	}


	public function add() {
        if (isset($this->passedArgs['comment'])) {
            $replyTo = $this->Comment->findById((int) $this->passedArgs['comment']);
            
            if (!$replyTo) {
                throw new NotFoundException(__('The comment you want to reply to doesn\'t exist'));
            }
            
            $this->Post->id = $replyTo['CommentedOn']['id'];
        }
        if (isset($this->passedArgs['post'])) {
            $this->Post->id = (int) $this->passedArgs['post'];
        }
        
        
        $this->request->data['Comment']['post_id'] = $this->Post->id;
        if (isset($this->passedArgs['comment'])) {
            $this->request->data['Comment']['reply_to'] = $this->passedArgs['comment'];
        }
        
        $post = $this->Post->read();
        $this->set('post', $post);
        if (!$post) {
            throw new NotFoundException(__('Could not find that post'));
        }
        
        if ($post['PostedBy']['id'] == $this->Auth->user('id')) {
            $scope = 'own';
        } elseif ((empty($post['Post']['school_id'])) && (empty($post['Post']['department_id']))) {
            $scope = 'system';
        } else {
            $scope = null;
        }
        
        if ($this->Auth->user()) {
            $requester = 'user::' . $this->Auth->user('id');
        } else {
            $requester = 'role::anonymous';
        }
        
        $hasAccess = $this->Acl->check(
            $requester, array('scope' => $scope, 'permission' => 'comment', 'school_id' => $post['Post']['school_id'], 'department_id' => $post['Post']['department_id']), 'create'
        );
        if (!$hasAccess) {
            throw new ForbiddenException();
        }
        
        if ($this->request->is('post')) {
            $this->request->data['Comment']['user_id'] = $this->Auth->user('id');
            $this->Comment->create();
            if ($this->Comment->save($this->request->data)) {
                $this->Session->setFlash(__('Your comment has been created'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));

                return $this->redirect(array('controller' => 'posts', 'action' => 'view', $this->request->data['Comment']['post_id']));
            }
            
            debug($this->request->data);
            
            debug($this->Comment->validationErrors);

            $this->Session->setFlash(__('Could not create your comment'), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-danger'
            ));
        }
    }
    
    public function edit($id) {
        if (!$id) {
            throw new NotFoundException(__('Invalid comment'));
        }

        $comment = $this->Comment->findById($id);
        if (!$comment) {
            throw new NotFoundException(__('Invalid comment'));
        }
        
        debug($comment);
        
        if ($comment['Comment']['user_id'] == $this->Auth->user('id')) {
            $scope = 'own';
        } elseif ((empty($comment['CommentedOn']['school_id'])) && (empty($comment['CommentedOn']['department_id']))) {
            $scope = 'system';
        } elseif (($comment['CommentedOn']['school_id'] == $this->School->id) && (empty($comment['CommentedOn']['department_id']))) {
            $scope = 'school';
        } elseif (($comment['CommentedOn']['school_id'] == $this->School->id) && ($comment['CommentedOn']['department_id'] == $this->Department->id)) {
            $scope = 'department';
        } else {
            $scope = 'other';
        }
        
        var_dump($scope);
        
        $hasAccess = $this->Acl->check(
            'user::' . $this->Auth->user('id'), array('scope' => $scope, 'permission' => 'comment', 'school_id' => $comment['CommentedOn']['school_id'], 'department_id' => $comment['CommentedOn']['department_id']), 'update'
        );
        if (!$hasAccess) {
            throw new ForbiddenException();
        }
        
        debug($hasAccess);

        if ($this->request->is(array('post', 'put'))) {
            $this->Comment->id = $id;
            if ($this->Comment->save($this->request->data)) {
                $this->Session->setFlash(__('Your comment has been updated.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));

                return $this->redirect(array('controller' => 'posts', 'action' => 'view', $comment['Comment']['post_id']));
            }

            $this->Session->setFlash(__('Unable to update your comment.'), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-danger'
            ));
        }
        
        if (!$this->request->data) {
            $this->request->data = $comment;
        }
    }

	public function latest() {
		$allowedScopes = $this->PermissionCheck->getScopes('post', 'read');

		if (empty($allowedScopes)) {
			throw new ForbiddenException();
		}

		$this->set('can_post', $this->PermissionCheck->checkPermission('post', 'create'));

		$conditions = array();
		$conditions['and']['CommentedOn.published'] = true;
		if (in_array('system', $allowedScopes)) {
			$conditions['and']['or'][] = array(
				'and' => array(
					'CommentedOn.school_id IS NULL',
					'CommentedOn.department_id IS NULL'
				)
			);
		}
		if (in_array('school', $allowedScopes)) {
			$conditions['and']['or'][] = array(
				'and' => array(
					'CommentedOn.school_id' => $this->School->id,
					'CommentedOn.department_id IS NULL'
				)
			);
		}
		if (in_array('department', $allowedScopes)) {
			$conditions['and']['or'][] = array(
				'and' => array(
					'CommentedOn.school_id' => $this->School->id,
					'CommentedOn.department_id' => $this->Department->id
				)
			);
		}
		if ((in_array('own', $allowedScopes)) && ($this->Auth->user())) {
			$conditions['and']['or'][] = array(
				'and' => array(
					'CommentedOn.user_id' => $this->Auth->user('id'),
					'CommentedOn.school_id' => $this->School->id,
					array(
						'or' => array(
							'CommentedOn.department_id' => $this->Department->id,
							'CommentedOn.department_id IS NULL'
						)
					)
				)
			);
		}

		$latest_comments = $this->Paginator->paginate('Comment', $conditions);

		if ($this->request->is('requested')) {
			return $latest_comments;
		}
	}
    
}