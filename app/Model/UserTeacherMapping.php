<?php
class UserTeacherMapping extends AppModel {

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		),
		'Teacher' => array(
			'className' => 'Teacher',
			'foreignKey' => 'teacher_id'
		)
	);
}

