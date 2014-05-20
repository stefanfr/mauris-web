<?php
$this->Title->addSegment(__('News'));
$this->Title->setPageTitle(__('Edit post'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	$this->here,
));

echo $this->element('page_header');

echo $this->ModelForm->create('Post');

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
