<?php
/**
 * @var $user_balance array
 */
$this->Title->addSegment(__('Vending machine'));
$this->Title->addSegment(__('User balances'));
$this->Title->setPageTitle(__('Change balance account of %1$s', $user_balance['User']['username']));

$this->Title->addCrumbs(array(
	array('controller' => 'vending_machine'),
	array('action' => 'index'),
	array('action' => 'edit', $user_balance['User']['id']),
));

echo $this->element('page_header');

echo $this->ModelForm->create('UserBalance');

echo $this->Form->input('balance');

echo $this->Form->submit(__('Change'), array(
	'div'   => 'col col-md-9 col-md-offset-3',
	'class' => 'btn btn-default'
));

echo $this->Form->end();
