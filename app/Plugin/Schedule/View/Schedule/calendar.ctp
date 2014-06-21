
<?
$this->Html->scriptStart(array('block' => 'script'));
?>
var App = {};
App.fullBaseUrl = <?php echo json_encode(substr(Router::url('/'), 0, -1)); ?>;
<?php
$this->Html->scriptEnd();

$this->Title->addSegment(__('Schedule'));
$this->Title->setPageTitle(__('Calendar'));

$this->Title->addCrumbs(array(
	array('controller' => 'schedule', 'action' => 'index'),
	array('controller' => 'schedule', 'action' => 'index', 'type' => 'calendar')
));

$description_for_layout = __('Calendar of the %1$s schedule at %2$s', $department_name, $school_name);

$keywords_for_layout = array();
$keywords_for_layout[] = __('Schedule calendar');
$keywords_for_layout[] = __('School schedule');
$keywords_for_layout[] = $school_name;
$keywords_for_layout[] = $department_name;


$this->set(compact('description_for_layout', 'keywords_for_layout'));
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
$this->Html->script('Schedule.moment.min', array ('inline' => false));
$this->Html->script('Schedule.fullcalendar.min', array ('inline' => false));
$this->Html->css('Schedule.fullcalendar', array('inline' => false));
$this->Html->script('Schedule.app.calendar', array('inline' => false));

$this->set('loadingModal', true);
?>
<?=$this->Html->link(__('Simple schedule'), array_merge(array('controller' => 'schedule', 'action' => 'index', 'type' => 'simple'), $target))?>
<script>
var targetData = <?=json_encode($target)?>;
targetData.startDate = new Date(targetData.start * 1000);
targetData.endDate = new Date(targetData.end * 1000);
targetData.dateDate = new Date(targetData.date * 1000);
</script>
<div id='calendar'></div>