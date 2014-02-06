<?php
class Account extends AppModel {

	public $displayField = 'username';

	public $hasOne = array(
		'Profile' => array(
			'className' => 'Profile',
			'foreignKey' => 'account_id'
		)
	);
}
