<?
$this->Html->addCrumb(__('Schedule'), array('controller' => 'schedule', 'action' => 'index')); 
$this->Html->addCrumb(__('Calendar'), array('controller' => 'schedule', 'action' => 'index', 'type' => 'calendar'));


$title_for_layout = implode(' - ', array(__('Calendar'), __('Schedule')));
$description_for_layout = __('Calendar of the %1$s schedule at %2$s', $department_name, $school_name);

$keywords_for_layout = array();
$keywords_for_layout[] = __('Schedule calendar');
$keywords_for_layout[] = __('School schedule');
$keywords_for_layout[] = $school_name;
$keywords_for_layout[] = $department_name;


$this->set(compact('title_for_layout', 'description_for_layout', 'keywords_for_layout'));
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
$targetData['date'] = (int) $this->get('target_date');
$targetData['schoolId'] = (int) $this->get('target_school_id');
$targetData['departmentId'] = (int) $this->get('target_department_id');
?>
<?=$this->Html->link(__('Simple schedule'), array_merge(array('controller' => 'schedule', 'action' => 'index', 'type' => 'simple'), $target))?>
<script>
var targetData = <?=json_encode($targetData)?>;
targetData.startDate = new Date(targetData.start * 1000);
targetData.endDate = new Date(targetData.end * 1000);
targetData.dateDate = new Date(targetData.date * 1000);
</script>
<div id='calendar'></div>