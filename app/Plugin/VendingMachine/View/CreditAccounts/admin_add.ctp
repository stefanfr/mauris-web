<?php
$this->Title->addSegment(__('Vending machine'));
$this->Title->addSegment(__('Credit accounts'));
$this->Title->setPageTitle(__('Add credit account'));

$this->Title->addCrumbs(array(
	array('controller' => 'vending_machine'),
	array('action' => 'index'),
	array('action' => 'add')
));

echo $this->element('page_header');

echo $this->ModelForm->create('CreditAccount');

echo $this->Form->input('user_id', array('options' => $users));
echo $this->Form->input('credit');

echo $this->Form->submit(__('Add'), array(
	'div'   => 'col col-md-9 col-md-offset-3',
	'class' => 'btn btn-default'
));

echo $this->Form->end();
