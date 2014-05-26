<?php

App::uses('VendingMachineAppModel', 'VendingMachine.Model');

class Transaction extends VendingMachineAppModel {

	public $belongsTo = array(
		'CreditAccount' => array(
			'className' => 'VendingMachine.CreditAccount',
			'foreignKey' => 'credit_account_id'
		),
		'UsedCard' => array(
			'className' => 'VendingMachine.Card',
			'foreignKey' => 'card_id'
		)
	);

}