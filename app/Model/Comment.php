<?php

App::uses('AppModel', 'Model');

class Comment extends AppModel {
    
    public $validate = array(
        'post_id' => array(
            'rule' => array('decimal'),
        ),
        'user_id' => array(
            'rule' => array('decimal'),
        ),
        'parent_id' => array(
            'rule' => array('decimal'),
            'required' => false
        ),
        'body' => array(
            'rule' => 'notEmpty'
        )
    );

	public $actAs = array('Tree');
    
    public $belongsTo = array(
        'PostedBy' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
        'CommentedOn' => array(
            'className' => 'Post',
            'foreignKey' => 'post_id'
        ),
        'InReplyTo' => array(
            'className' => 'Comment',
            'foreignKey' => 'parent_id'
        ),  
    );

	/**
	 * Get the latest comments on posts
	 *
	 * @param $scopes array Post scopes to get comments for
	 * @param $organizationId int ID of the organization
	 * @param $departmentId int ID of the department
	 * @param $limit int Limit of comments to return
	 * @return array
	 */
	public function getLatestComments($scopes, $organizationId, $departmentId, $limit) {
		$conditions = array();
		$conditions['and']['CommentedOn.published'] = true;
		if (in_array('system', $scopes)) {
			$conditions['and']['or'][] = array(
				'and' => array(
					'CommentedOn.school_id IS NULL',
					'CommentedOn.department_id IS NULL'
				)
			);
		}
		if (in_array('school', $scopes)) {
			$conditions['and']['or'][] = array(
				'and' => array(
					'CommentedOn.school_id' => $organizationId,
					'CommentedOn.department_id IS NULL'
				)
			);
		}
		if (in_array('department', $scopes)) {
			$conditions['and']['or'][] = array(
				'and' => array(
					'CommentedOn.school_id'     => $organizationId,
					'CommentedOn.department_id' => $departmentId
				)
			);
		}

		return $this->find('all', array(
			'conditions' => $conditions,
			'recursive'  => 0,
			'order'      => array(
				'Comment.created' => 'DESC'
			),
			'limit'      => $limit
		));
	}
    
}
