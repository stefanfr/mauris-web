<?php

App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
    
    public $displayField = 'username';
    
    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        ),
        'email' => array(
	        array(
		        'rule' => 'email',
		        'message' => 'Enter a correct email address',
		        'require' => true
	        ),
	        array(
		        'rule' => 'notEmpty',
		        'require' => true
	        )
        ),
    );

    public $hasMany = array(
        'SubscribedToClasses' => array(
            'className' => 'UserClassMapping',
            'id'
        ),
        'RepresentsTeachers' => array(
            'className' => 'UserTeacherMapping',
            'id'
        )
    );
    
    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }
    
    public function getUserDetails($userId) {
        return $this->findById($userId);
    }
        
}
