<?php

App::uses('OrganizationManage', 'Lib');

class Post extends AppModel {
    
    public $validate = array(
        'scope' => array(
             'rule' => array('inList', array('system', 'school', 'department')),
         ),
        'title' => array(
            'rule' => 'notEmpty'
        ),
        'body' => array(
            'rule' => 'notEmpty'
        ),
        'published' => array(
            'rule' => array('boolean')
        )
    );
    
    public $hasMany = array(
        'Comments' => array(
            'className' => 'Comment',
            'foreignKey' => 'post_id'
        )
    );
    
    public $belongsTo = array(
        'IntentedForSchool' => array(
            'className' => 'School',
            'foreignKey' => 'school_id'
        ),
        'IntentedForDepartment' => array(
            'className' => 'Department',
            'foreignKey' => 'department_id'
        ),
        'PostedBy' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),  
    );

	public $actsAs = array(
		'OrganizationOwned'
	);
    
	public function getLatestPost($scopes, \OrganizationSelector $Selector) {
        $conditions = array();
        $conditions['Post.published'] = true;

		if (!in_array('school', $scopes)) {
			$Selector->unsetOrganization();
		}
		if (!in_array('department', $scopes)) {
			$Selector->unsetDepartment();
		}

		return $this->find(
			'first', array(
				'recursive'  => -1,
				'match'      => $Selector,
				'conditions' => $conditions,
				'order'      => array(
					'Post.created' => 'DESC'
				),
			)
		);
    }
    
}
