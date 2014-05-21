<?php
$this->Title->addSegment(__('Events'));
$this->Title->setPageTitle(__('Add event'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	$this->here
));

echo $this->element('page_header');

echo $this->ModelForm->create('Event');

echo $this->Form->input('school_id');
echo $this->Form->input('department_id');
echo $this->Form->input('title'); // @TODO Fix this
echo $this->Form->input('description');
echo $this->Form->input('start');
echo $this->Form->input('end');
echo $this->Form->input('all_day');
echo $this->Form->input('type', array(
	'options' => array(
		'holiday' => __('Holiday'),
		'other'   => __('Other')
	),
	'default' => 'other'
));
?>
<div class="form-group">
	<?php echo $this->Form->submit(__('Add'), array(
		'div'   => 'col col-md-9 col-md-offset-3',
		'class' => 'btn btn-default'
	)); ?>
</div>
<?php
echo $this->Form->end();
?>
