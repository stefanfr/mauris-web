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
        $conditions = array();
        $conditions['and']['Post.published'] = true; 
        if (in_array('system', $scopes)) {
            $conditions['and']['or'][] = array(
                'and' => array(
                    'Post.school_id IS NULL',
                    'Post.department_id IS NULL'
                )
            );
        }
        if (in_array('school', $scopes)) {
            $conditions['and']['or'][] = array(
                'and' => array(
                    'Post.school_id' => $schoolId,
                    'Post.department_id IS NULL'
                )
            );
        }
        if (in_array('department', $scopes)) {
            $conditions['and']['or'][] = array(
                'and' => array(
                    'Post.school_id' => $schoolId,
                    'Post.department_id' => $departmentId
                )
            );
        }
        
        return $this->find(
            'first', array(
                'recursive' => -1,
                'conditions' => $conditions,
                'order' => array(
                    'Post.created' => 'DESC'
                ),
            )
        );
    }
    
}
