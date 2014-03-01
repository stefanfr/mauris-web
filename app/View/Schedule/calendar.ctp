<?
$this->Html->addCrumb(__('Schedule'), array('controller' => 'schedule', 'action' => 'index')); 
$this->Html->addCrumb(__('Calendar'), array('controller' => 'schedule', 'action' => 'index', 'type' => 'calendar'));
?>
<?=$this->start('rightMenu'); ?>
<form class="navbar-form navbar-right">
	<select id="selector-teacher" class="form-control">
			<option disabled><?=__('Teacher'); ?></option>
		<?php foreach ($this->get('teachers') as $teacher): ?>
			<option value="<?=$teacher['id']?>"><?=($teacher['name']) ? $teacher['name'] : $teacher['abbreviation']?></option>
		<?php endforeach; ?>
	</select>
	<select id="selector-class" class="form-control">
			<option disabled><?=__('Class'); ?></option>
		<?php foreach ($this->get('classes') as $class): ?>
			<option value="<?=$class['id']?>"><?=$class['name']?></option>
		<?php endforeach; ?>
	</select>
</form>
<?=$this->end(); ?>
<?php
$this->Html->script('fullcalendar.min', array ('inline' => false));
$this->Html->css('fullcalendar', array('inline' => false));
$this->Html->script('app.calendar', array('inline' => false));

$this->set('loadingModal', true);

$targetData = array();
$target = array();
if ($this->get('target_class_id')) {
    $targetData['classId'] = (int) $this->get('target_class_id');
    $target['class'] = (int) $this->get('target_class_id');
}
if ($this->get('target_teacher_id')) {
    $targetData['teacherId'] = (int) $this->get('target_teacher_id');
    $target['teacher'] = (int) $this->get('target_teacher_id');
}
if ($this->get('target_classroom_id')) {
    $targetData['classroomId'] = (int) $this->get('target_classroom_id');
    $target['classroom'] = (int) $this->get('target_classroom_id');
}
$targetData['start'] = (int) $this->get('target_start');
$targetData['end'] = (int) $this->get('target_end');
$targetData['departmentId'] = (int) $this->get('target_department_id');
?>
<?=$this->Html->link(__('Simple schedule'), array_merge(array('controller' => 'schedule', 'action' => 'index', 'type' => 'simple'), $target))?>
<script>
var targetData = <?=json_encode($targetData)?>;
targetData.startDate = new Date(targetData.start * 1000);
targetData.endDate = new Date(targetData.end * 1000);
</script>
<div id='calendar'></div>