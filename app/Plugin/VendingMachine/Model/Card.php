<?php

App::uses('VendingMachineAppModel', 'VendingMachine.Model');

class Card extends VendingMachineAppModel {

	public $displayField = 'code';

	public $belongsTo = array(
		'CreditAccount' => array(
			'className' => 'VendingMachine.CreditAccount',
			'foreignKey' => 'credit_account_id'
		)
	);

}