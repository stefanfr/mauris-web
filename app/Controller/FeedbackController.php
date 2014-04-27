<?php

App::uses('CakeEmail', 'Network/Email');

class FeedbackController extends AppController {
    
    public $uses = array('FeedbackEntry');
    
    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->Auth->allow('add');
    }
    
    public function add() {
        if ($this->Auth->user()) {
            $requester = 'user::' . $this->Auth->user('id');
        } else {
            $requester = 'role::anonymous';
        }
        $allowed = $this->Acl->check(
            $requester, array('scope' => 'system', 'permission' => 'feedback', 'school_id' => $this->School->id, 'department_id' => $this->Department->id), 'create'
        );
        if (!$allowed) {
            throw new ForbiddenException();
        }
        if ($this->request->is('post')) {
            $this->request->data['FeedbackEntry']['user_id'] = $this->Auth->user('id');
            $this->request->data['FeedbackEntry']['school_id'] = $this->School->id;
            $this->request->data['FeedbackEntry']['department_id'] = $this->Department->id;
            $this->request->data['FeedbackEntry']['created'] = date('Y-m-d H:i:s');

            $this->FeedbackEntry->create();
            if ($this->FeedbackEntry->save($this->request->data)) {

                $email = new CakeEmail();
                $email->emailFormat('both');
                $email->from(array('website@ictcollege.eu' => 'Feedback ICTCollege'));
                $email->to('m.cremers@cvo-technologies.com');
                $email->subject('Feedback');
                $email->template('feedback_submitted');
                $email->viewVars(
                    array(
                        'data' => $this->request->data,
                        'id' => $this->FeedbackEntry->id,
                        'user' => $this->Auth->user(),
                        'school_name' => $this->School->field('name'),
                        'department_name' => $this->Department->field('name')
                    )
                );
                $email->send();

                $this->Session->setFlash(__('Thank you for your feedback!'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
				
                return $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
            }
            
            $this->Session->setFlash(__('Could not add your feedback'), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-danger'
            ));
        }
    }
    
}