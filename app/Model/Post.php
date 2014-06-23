<?php

class Post extends AppModel {

	public $actsAs = array(
		'OrganizationOwned'
	);

	public $validate = array(
		'scope'     => array(
			'rule'     => array('inList', array('system', 'school', 'department')),
			'required' => true
		),
		'title'     => array(
			'required' => true
		),
		'body'      => array(
			'required' => true
		),
		'published' => array(
			'rule'     => array('boolean'),
			'required' => true
		)
	);
    
    public $hasMany = array(
        'Comment' => array(
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
    
    public function getLatestPost($scopes, $schoolId, $departmentId) {
	    return $this->find('first', array(
		    'recursive'    => -1,
		    'conditions'   => array(
			    $this->alias . '.published' => true
		    ),
		    'order'        => array(
			    $this->alias . '.created' => 'DESC'
		    ),
		    'scopes'       => $scopes,
		    'organization' => $schoolId,
		    'department'   => $departmentId
	    ));
    }

	public function getScope($post, $user, $organization, $department) {
		if ($post['PostedBy']['id'] == $user) {
			return 'own';
		}
		if ((!empty($post['Post']['department_id'])) && ($post['Post']['department_id'] == $department)) {
			return 'department';
		}
		if ((!empty($post['Post']['school_id'])) && ($post['Post']['school_id'] == $organization)) {
			return 'school';
		}

		return 'system';
	}
    
}
