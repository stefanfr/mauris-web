<?php

App::uses('CakeEmail', 'Network/Email');

/**
 * Class FeedbackController
 *
 * @property Feedback Feedback
 */
class FeedbackController extends AppController {

	public $components = array(
		'Paginator' => array(
			'settings' => array(
				'limit'     => 5,
				'recursive' => 2,
				'order'     => array(
					'Feedback.created DESC',
				)
			)
		),
		'AutoPermission'
	);

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
	        $success = $this->Feedback->addFeedback(
		        $this->request->data, $this->Auth->user(),
		        $this->SchoolInformation->getSchoolId(),
		        $this->SchoolInformation->getDepartmentId()
	        );
            if ($success) {
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

	public function admin_index() {
		$this->set('feedback', $this->Paginator->paginate('Feedback'));
	}

	public function admin_view($id) {
		$this->Feedback->id = $id;

		$feedback = $this->Feedback->read();
		if (!$feedback) {
			throw new NotFoundException();
		}

		$this->set(compact('feedback'));
	}

}