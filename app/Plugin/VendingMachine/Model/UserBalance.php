<?php

App::uses('VendingMachineAppModel', 'VendingMachine.Model');

class UserBalance extends VendingMachineAppModel {

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
			'foreignKey' => 'user_balance_id'
		)
	);

	public function applyTransaction($transaction) {
		$this->id = $transaction['Transaction']['user_balance_id'];

		$UserBalance = $this->read();
		$UserBalance['UserBalance']['balance'] += $transaction['Transaction']['amount'];
		$this->save($UserBalance);
	}

}