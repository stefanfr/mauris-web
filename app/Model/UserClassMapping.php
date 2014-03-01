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
}

