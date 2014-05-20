<?php
/**
 * @var $schedule_entry array
 */

$this->Title->addSegment(__('Schedule'));
$this->Title->setPageTitle(__('Change schedule'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	array($schedule_entry['ScheduleEntry']['id'])
));

$this->set('title_for_layout', $this->Title->getPageTitle());

echo $this->element('page_header');

echo $this->Form->create('ScheduleEntry', array(
	'inputDefaults' => array(
		'div'       => 'form-group',
		'label'     => array(
			'class' => 'col col-md-3 control-label'
		),
		'wrapInput' => 'col col-md-9',
		'class'     => 'form-control'
	),
	'class'         => 'form-horizontal'
));
echo $this->Form->input('date');
echo $this->Form->input('period');
?>
<fieldset>
	<legend><?php echo h(__('Details')) ?></legend>
	<?php
	echo $this->Form->input('class_id');
	echo $this->Form->input('subject_id');
	echo $this->Form->input('teacher_id');
	echo $this->Form->input('classroom_id');
	?>
</fieldset>
<fieldset>
	<legend><?php echo h(__('Options')) ?></legend>
	<?php
	echo $this->Form->input('cancelled', array('checked' => $schedule_entry['ScheduleEntry']['cancelled']));
	?>
</fieldset>
<fieldset>
	<legend><?php echo h(__('Scope')) ?></legend>
	<?php
	echo $this->Form->input('department_id');
	?>
</fieldset>

<div class="form-group">
	<?php
	echo $this->Form->submit(__('Change'), array(
		'div'   => 'col col-md-9 col-md-offset-3',
		'class' => 'btn btn-default'
	));
	?>
</div>
<?php
echo $this->Form->end();
?>
