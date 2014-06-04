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
    
}
