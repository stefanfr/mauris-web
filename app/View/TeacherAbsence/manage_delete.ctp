<?
$this->Title->addSegment(__('Teacher absence'));
$this->Title->setPageTitle(__('Remove absence report'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	$this->here
));

echo $this->element('page_header');

echo $this->Form->postButton(
	'<span class="glyphicon glyphicon-trash"></span> ' . h(__('Remove')),
	array($id),
	array(
		'class' => 'btn btn-default',
	)
);
?>
