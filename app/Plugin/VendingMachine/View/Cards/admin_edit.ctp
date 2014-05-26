<?php
/**
 * @var $card array
 * @var $credit_accounts array
 */
$this->Title->addSegment(__('Vending machine'));
$this->Title->addSegment(__('Cards'));
$this->Title->setPageTitle(__('Change %1$s', $card['Card']['code']));

$this->Title->addCrumbs(array(
	array('controller' => 'vending_machine'),
	array('action' => 'index'),
	array('action' => 'edit', $card['Card']['id']),
));

debug($credit_accounts);

echo $this->element('page_header');

echo $this->ModelForm->create('Card');

echo $this->Form->input('credit_account_id', array('options' => $credit_accounts));
echo $this->Form->input('code');

echo $this->Form->submit(__('Change'), array(
	'div'   => 'col col-md-9 col-md-offset-3',
	'class' => 'btn btn-default'
));

echo $this->Form->end();
