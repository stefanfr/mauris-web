<?php
$this->Title->addSegment(__('Events'));
$this->Title->setPageTitle(__('Remove %1$s', $event['Event']['title']));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	$this->here
));

echo $this->element('page_header');

echo $this->Form->postButton(
	'<span class="glyphicon glyphicon-trash"></span> ' . h(__('Remove')),
	array($event['Event']['id']),
	array(
		'class' => 'btn btn-default',
	)
);
?>
