<?php

App::uses('VendingMachineAppModel', 'VendingMachine.Model');

class Card extends VendingMachineAppModel {

	public $displayField = 'code';

	public $belongsTo = array(
		'UserBalance' => array(
			'className' => 'VendingMachine.UserBalance',
			'foreignKey' => 'user_balance_id'
		)
	);

}