<?php
class UserClassMapping extends AppModel {

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		),
		'Class' => array(
			'className' => 'AClass',
			'foreignKey' => 'class_id'
		)
	);
        
    public function getUserClassSubscriptions($userId, $departmentId) {
        return $this->find(
            'all',
            array(
                'conditions' => array(
                    'User.id' => $userId,
                    'Class.department_id' => $departmentId
                ),
	            'recursive'  => 0
            )
        );
    }
}

