<?php
$this->Title->addSegment(__('News'));
$this->Title->setPageTitle(__('Edit post'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	$this->here,
));
?>
<h1><?php echo h($this->Title->getPageTitle()) ?></h1>
<?php
echo $this->Form->create('Post', array(
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-3 control-label'
		),
		'wrapInput' => 'col col-md-9',
		'class' => 'form-control'
	),
	'class' => 'form-horizontal'
	));
echo $this->Form->input('title');
echo $this->Form->input('body', array('rows' => '3'));
echo $this->Form->input('id', array('type' => 'hidden'));
?>
<div class="form-group">
	<?php echo $this->Form->submit(__('Change'), array(
		'div' => 'col col-md-9 col-md-offset-3',
		'class' => 'btn btn-default'
	)); ?>
</div>
<?php
echo $this->Form->end();
?>
