<?php
$this->Title->addSegment(__('Vending machine'));
$this->Title->addSegment(__('Cards'));
$this->Title->setPageTitle(__('Add card'));

$this->Title->addCrumbs(array(
	array('controller' => 'vending_machine'),
	array('action' => 'index'),
	array('action' => 'add')
));

echo $this->element('page_header');

echo $this->ModelForm->create('Card');

echo $this->Form->input('user_balance_id', array('options' => $user_balances));
echo $this->Form->input('code');
echo $this->Form->input('name');

echo $this->Form->submit(__('Add'), array(
	'div'   => 'col col-md-9 col-md-offset-3',
	'class' => 'btn btn-default'
));

echo $this->Form->end();
