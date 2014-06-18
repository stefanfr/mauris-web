<?php
$this->Title->addSegment(__('Assignments'));
$this->Title->setPageTitle(__('Add assignment'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	array('action' => 'add')
));

echo $this->element('page_header');

echo $this->ModelForm->create('Assignment');

echo $this->Form->input('title');
echo $this->Form->input('description');
?>
<div class="form-group">
	<?php
	echo $this->Form->submit(__('Add'), array(
		'div'   => 'col col-md-9 col-md-offset-3',
		'class' => 'btn btn-default'
	));
	?>
</div>
<?php
echo $this->Form->end();
?>
