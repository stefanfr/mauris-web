<?php
/**
 * @var $card array
 * @var $user_balances array
 */
$this->Title->addSegment(__('Vending machine'));
$this->Title->addSegment(__('Cards'));
$this->Title->setPageTitle(__('Change %1$s', $card['Card']['code']));

$this->Title->addCrumbs(array(
	array('controller' => 'vending_machine'),
	array('action' => 'index'),
	array('action' => 'edit', $card['Card']['id']),
));

debug($user_balances);

echo $this->element('page_header');

echo $this->ModelForm->create('Card');

echo $this->Form->input('user_balance_id', array('options' => $user_balances));
echo $this->Form->input('code');

echo $this->Form->submit(__('Change'), array(
	'div'   => 'col col-md-9 col-md-offset-3',
	'class' => 'btn btn-default'
));

echo $this->Form->end();
