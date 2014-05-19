<?
$this->Title->addSegment(__('Teacher absence'));
$this->Title->setPageTitle(__('Remove absence report'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	$this->here
));
?>
<h1><?php echo h($this->Title->getPageTitle()) ?></h1>
<?
echo $this->Form->postButton(
	'<span class="glyphicon glyphicon-trash"></span> ' . h(__('Remove')),
	array($id),
	array(
		'class' => 'btn btn-default',
	)
);
?>
