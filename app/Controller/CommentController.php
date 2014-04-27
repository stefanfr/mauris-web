<?php
class CommentController extends AppController {

    public $uses = array('Comment', 'Post', 'User');
    
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
    
}