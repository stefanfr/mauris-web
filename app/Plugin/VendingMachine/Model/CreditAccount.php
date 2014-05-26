<?php

App::uses('VendingMachineAppModel', 'VendingMachine.Model');

class CreditAccount extends VendingMachineAppModel {

	public $primaryKey = 'user_id';

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		)
	);

	public $hasMany = array(
		'Card' => array(
			'className' => 'VendingMachine.Card',
			'foreignKey' => 'credit_account_id'
		)
	);

	public function applyTransaction($transaction) {
		$this->id = $transaction['Transaction']['credit_account_id'];

		$creditAccount = $this->read();
		$creditAccount['CreditAccount']['credit'] += $transaction['Transaction']['amount'];
		$this->save($creditAccount);
	}

}