<?php

$this->Title->addSegment(__('Role assignments'));
$this->Title->addSegment(__('Students'));
$this->Title->setPageTitle(__('Add'));

$this->Title->addCrumbs(array(
	array('controller' => 'user_role_mappings'),
	array('action' => 'index'),
	array('action' => 'add')
));

echo $this->element('page_header');

echo $this->ModelForm->create('UserRoleMapping');

echo $this->Form->input('user_id');

echo $this->Form->submit(__('Add'), array(
	'div' => 'col col-md-9 col-md-offset-3',
	'class' => 'btn btn-default'
));

echo $this->Form->end();

echo $this->element('button/back');
?>