<?php

$this->Title->addSegment(__('Role assignments'));
$this->Title->setPageTitle(__('Add'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	array('action' => 'add'),
));

echo $this->element('page_header');

echo $this->Html->link(
	'<span class="fa fa-plus"></span> ' . h(__('Add student')),
	array('controller' => 'students', 'action' => 'add'),
	array('class' => 'btn btn-default', 'escape' => false)
);