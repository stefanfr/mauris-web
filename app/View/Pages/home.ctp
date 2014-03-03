<?
$keywords_for_layout = array();
$keywords_for_layout[] = __('Student information');
$keywords_for_layout[] = __('Student information for %s', $school_name);
$keywords_for_layout[] = __('Student information for %s', $department_name);
$keywords_for_layout[] = __('Class schedule');
$keywords_for_layout[] = __('Schedule');
$keywords_for_layout[] = __('Teacher');
$keywords_for_layout[] = __('Teacher information');
$keywords_for_layout[] = __('Teacher absence');
$keywords_for_layout[] = __('Assignments');
$keywords_for_layout[] = __('Homework');

$this->set(compact('keywords_for_layout'));
$this->set('description_for_layout', __('%1$s school information for teachers, students and parents at the %2$s department', $school_name, $department_name));
?>

<?=$this->start('additionalStyle'); ?>
.navbar-static-top{
	margin-bottom: 0px;
}
<?=$this->end(); ?>
<?=$this->start('beforeContainer'); ?>
<? if ($latest_post): ?>
<div class="jumbotron">
	<div class="container">
		<h1><?=__('Latest news')?></h1>
                <h2><?=h($latest_post['Post']['title'])?></h2>
                <p>
                <? if ($latest_post['Post']['summary']): ?>
                <?=h($latest_post['Post']['summary'])?>
                <? else: ?>
                <?=$this->Text->truncate($latest_post['Post']['body'], 500)?>
                <? endif; ?>
                </p>
                <p><?=$this->Html->link(__('Read more'), array('controller' => 'posts', 'action' => 'view', $latest_post['Post']['id']), array('class' => 'btn btn-primary btn-lg', 'role' => 'buttom'))?></p>
	</div>
</div>
<? endif; ?>
<?=$this->end(); ?>

<div class="row">
	<div class="col-md-4">
		<h2><?=__n('Absent teacher', 'Absent teachers', count($absent_teachers))?></h2>
                <p><?=__('Absent teachers for the 7 following days')?></p>
		<table class="table">
                    <tr>
                        <th><?=__('Date')?></th>
                        <th><?=__('Teacher')?></th>
                    </tr>
                    <? foreach ($absent_teachers as $report): ?>
                    <tr>
                        <th><?=h(date('l', strtotime($report['TeacherAbsenceReport']['date'])))?></th>
                        <th><?=$this->Html->link(($report['AffectedTeacher']['name']) ? $report['AffectedTeacher']['name'] : $report['AffectedTeacher']['abbreviation'], array('controller' => 'teacher', 'action' => 'view', $report['TeacherAbsenceReport']['teacher_id']))?></th>
                    </tr>
                    <? endforeach; ?>
                </table>
                <p><?=__n('%d absent teacher report', '%d absent teachers reports', count($absent_teachers), count($absent_teachers))?></p>
	</div>
	<div class="col-md-4">
		<h2><?=h(__('Heading'))?></h2>
		<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
		<p><a class="btn btn-default" href="#" role="button"><?=h(__('View details »'))?></a></p>
	</div>
	<div class="col-md-4">
		<h2><?=__n('Available classroom', 'Available classrooms', count($classrooms_available))?></h2>
                <p><?=__n('Classroom available at: %s', 'Classrooms available at: %s', count($classrooms_available), strftime('%X', $classrooms_available_timestamp))?></p>
                <table class="table">
                    <tr>
                        <th><?=__('Classroom')?></th>
                        <th><?=__('Title')?></th>
                    </tr>
                    <? foreach ($classrooms_available as $classroom): ?>
                    <tr>
                        <th><?=$this->Html->link($classroom['Classroom']['code'], array('controller' => 'classroom', 'action' => 'view', $classroom['Classroom']['id']))?></th>
                        <th><?=@$classroom['MappingInformation']['ClassroomDetails']['title']?></th>
                    </tr>
                    <? endforeach; ?>
                </table>
	</div>
</div>
