<?php
/**
 * @var $credit_account array
 */
$this->Title->addSegment(__('Vending machine'));
$this->Title->addSegment(__('Credit accounts'));
$this->Title->setPageTitle(__('Change credit account of %1$s', $credit_account['User']['username']));

$this->Title->addCrumbs(array(
	array('controller' => 'vending_machine'),
	array('action' => 'index'),
	array('action' => 'edit', $credit_account['User']['id']),
));

echo $this->element('page_header');

echo $this->ModelForm->create('CreditAccount');

echo $this->Form->input('credit');

echo $this->Form->submit(__('Change'), array(
	'div'   => 'col col-md-9 col-md-offset-3',
	'class' => 'btn btn-default'
));

echo $this->Form->end();
