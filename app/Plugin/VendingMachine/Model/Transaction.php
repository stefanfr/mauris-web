<?php

App::uses('VendingMachineAppModel', 'VendingMachine.Model');

class Transaction extends VendingMachineAppModel {

	public $validate = array(
		'amount' => array(
			'rule'    => array('checkBalance'),
			'message' => 'The user has insufficient balance.'
		)
	);

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

	public function checkBalance($check) {
		$this->UserBalance->id = $this->data['Transaction']['user_balance_id'];
		$userBalance = $this->UserBalance->read();

		return ($userBalance['UserBalance']['balance'] + $check['amount']) > 0;
	}

}