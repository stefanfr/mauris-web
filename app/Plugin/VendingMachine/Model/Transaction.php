<?php

App::uses('VendingMachineAppModel', 'VendingMachine.Model');

class Transaction extends VendingMachineAppModel {

	public $belongsTo = array(
		'UserBalance' => array(
			'className' => 'VendingMachine.UserBalance',
			'foreignKey' => 'user_balance_id'
		),
		'UsedCard' => array(
			'className' => 'VendingMachine.Card',
			'foreignKey' => 'card_id'
		)
	);

}