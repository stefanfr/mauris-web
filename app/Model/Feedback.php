<?php

class Feedback extends AppModel {

	public $validate = array(
		'school_id'     => array(
			'rule' => array('decimal'),
		),
		'department_id' => array(
			'rule' => array('decimal'),
		),
		'body'          => array(
			'rule' => 'notEmpty'
		),
	);

	public $belongsTo = array(
		'ByUser' => array(
			'className'  => 'User',
			'foreignKey' => 'user_id'
		)
	);

}