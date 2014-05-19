<?
$this->Html->addCrumb(__('Teacher absence'), array('action' => 'index'));
$this->Html->addCrumb(
	__('Change absence report'),
	$this->here
);
?>
<h1><?= h(__('Change absence report')) ?></h1>
<?
echo $this->Form->create('TeacherAbsenceReport', array(
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
$teacherOptions = array();
foreach ($teachers as $teacher) {
	$teacherOptions[$teacher['id']] = ($teacher['name']) ? $teacher['name'] . ' - ' . $teacher['abbreviation'] : $teacher['abbreviation'];
}
?>
<?=
$this->Form->input('teacher_id', array(
	'options' => $teacherOptions,
	'type'    => 'select',
	'label'   => __('Teacher')
))?>
<?= $this->Form->input('date', array('type' => 'date')) ?>
<div class="form-group">
	<?php echo $this->Form->submit(__('Change'), array(
		'div'   => 'col col-md-9 col-md-offset-3',
		'class' => 'btn btn-default'
	)); ?>
</div>
<?php
echo $this->Form->end();
?>
