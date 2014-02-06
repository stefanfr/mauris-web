<?php
class Profile extends AppModel {

	public $displayField = 'surname';

	public $belongsTo = array(
		'Account' => array(
			'className' => 'Account',
			'foreignKey' => 'account_id'
		)
	);
}
