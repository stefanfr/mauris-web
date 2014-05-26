<?php
$this->Title->addSegment(__('Vending machine'));
$this->Title->addSegment(__('Transactions'));
$this->Title->setPageTitle(__('Add transaction'));

$this->Title->addCrumbs(array(
	array('controller' => 'vending_machine'),
	array('action' => 'index'),
	array('action' => 'add')
));

echo $this->element('page_header');

echo $this->ModelForm->create('Transaction');

echo $this->Form->input('credit_account_id', array('options' => $credit_accounts));
echo $this->Form->input('card_id', array('empty' => __('None')));
echo $this->Form->input('amount');

echo $this->Form->submit(__('Add'), array(
	'div'   => 'col col-md-9 col-md-offset-3',
	'class' => 'btn btn-default'
));

echo $this->Form->end();
