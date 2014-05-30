<?
$this->Title->setPageTitle(__('Home'));

$keywords_for_layout = array();
$keywords_for_layout[] = __('Student information');
if (isset($school_name)) {
    $keywords_for_layout[] = __('Student information for %s', $school_name);
}
if (isset($department_name)) {
    $keywords_for_layout[] = __('Student information for %s', $department_name);
}
$keywords_for_layout[] = __('Class schedule');
$keywords_for_layout[] = __('Schedule');
$keywords_for_layout[] = __('Teacher');
$keywords_for_layout[] = __('Teacher information');
$keywords_for_layout[] = __('Teacher absence');
$keywords_for_layout[] = __('Assignments');
$keywords_for_layout[] = __('Homework');

$this->set(compact('keywords_for_layout'));
if (isset($department_name)) {
    $this->set('description_for_layout', __('%1$s school information for teachers, students and parents at the %2$s department', $school_name, $department_name));
} elseif (isset($school_name)) {
    $this->set('description_for_layout', __('%1$s school information for teachers, students and parents', $school_name));
}
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
                <p><?=$this->Html->link(__('Read more'), array('controller' => 'posts', 'action' => 'view', $latest_post['Post']['id'], Inflector::slug($latest_post['Post']['title'])), array('class' => 'btn btn-primary btn-lg', 'role' => 'buttom'))?></p>
	</div>
</div>
<? endif; ?>
<?=$this->end(); ?>

<div class="row">
	<div class="col-md-4">
		<h2><?php echo h(__('Account')); ?></h2>
		<?php
		if ($logged_in):
			?>
			<p><?php echo h(__('You\'re logged in as %1$s', $current_user['username'])); ?></p>
			<div class="row">
				<div class="col-sm-12 col-md-6"><?php echo $this->Html->link(__('Profile'), array('controller' => 'users', 'action' => 'profile'), array('class' => 'btn btn-primary')); ?></div>
				<div class="col-sm-12 col-md-6"><?php echo $this->Html->link(__('Logout'), array('controller' => 'users', 'action' => 'logout'), array('class' => 'btn btn-danger')); ?></div>
			</div>
			<?php
		else:
			?>
			<div class="row">
				<div class="col-sm-12 col-md-6"><?php echo $this->Html->link(__('Login'), array('controller' => 'users', 'action' => 'login'), array('class' => 'btn btn-primary')); ?></div>
				<div class="col-sm-12 col-md-6"><?php echo $this->Html->link(__('Register'), array('controller' => 'users', 'action' => 'register'), array('class' => 'btn btn-primary')); ?></div>
			</div>
			<?php
		endif;
		?>
	</div>
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
                        <th><?=h($this->Time->i18nFormat($report['TeacherAbsenceReport']['date'], '%A', 'Europe/Amsterdam'))?></th>
                        <th><?=$this->Html->link(($report['AffectedTeacher']['name']) ? $report['AffectedTeacher']['name'] : $report['AffectedTeacher']['abbreviation'], array('controller' => 'teacher', 'action' => 'view', $report['TeacherAbsenceReport']['teacher_id']))?></th>
                    </tr>
                    <? endforeach; ?>
                </table>
                <p><?=__n('%d absent teacher report', '%d absent teachers reports', count($absent_teachers), count($absent_teachers))?></p>
	</div>
	<?php if ($logged_in): ?>
    <div class="col-md-4">
        <h2><?=__n('Class subscription', 'Class subscriptions', count($user_class_subscriptions))?></h2>
        <p><?=__('This table shows the classes you\'ve subscriped to')?></p>
        <table class="table">
            <tr>
                <th><?=__('Class')?></th>
            </tr>
            <? foreach ($user_class_subscriptions as $classroomSubscription): ?>
            <tr>
                <th><?=$this->Html->link($classroomSubscription['Class']['name'], array('controller' => 'schedule', 'action' => 'index', 'class' => $classroomSubscription['Class']['id']))?></th>
            </tr>
            <? endforeach; ?>
        </table>
    </div>
	<?php endif; ?>
	<div class="col-md-4">
		<h2><?=__n('Available classroom', 'Available classrooms', count($classrooms_available))?></h2>
                <p><?=__n('Classroom available at: %s', 'Classrooms available at: %s', count($classrooms_available), $this->Time->i18nFormat($classrooms_available_timestamp, '%X', null, 'Europe/Amsterdam'))?></p>
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
<div class="row">
    <div class="col-md-4">
        <h2><?=h(__('Feedback'))?></h2>
        <?
        echo $this->Form->create('Feedback', array(
            'inputDefaults' => array(
                'div' => 'form-group',
                'label' => false,
                'class' => 'form-control'
            ),
            'class' => 'form-horizontal',
            'url' => array(
                'controller' => 'feedback',
                'action' => 'add'
            ),
        ));
        ?>

        <?=$this->Form->input('body', array('rows' => '5'))?>
                <?php echo $this->Form->submit(__('Add'), array(
                        //'div' => 'col col-md-9 col-md-offset-3',
                        'class' => 'btn btn-default'
                )); ?>
        <?=$this->Form->end()?>
    </div>
</div>