<?php
$this->Title->setPageTitle(__('Home'));

$keywords_for_layout = array();
$keywords_for_layout[] = __('Student information');
if (isset($school_name)):
	$keywords_for_layout[] = __('Student information for %s', $school_name);
endif;
if (isset($department_name)):
	$keywords_for_layout[] = __('Student information for %s', $department_name);
endif;
$keywords_for_layout[] = __('Class schedule');
$keywords_for_layout[] = __('Schedule');
$keywords_for_layout[] = __('Teacher');
$keywords_for_layout[] = __('Teacher information');
$keywords_for_layout[] = __('Teacher absence');
$keywords_for_layout[] = __('Assignments');
$keywords_for_layout[] = __('Homework');

$this->set(compact('keywords_for_layout'));
if (isset($department_name)):
	$this->set('description_for_layout', __('%1$s school information for teachers, students and parents at the %2$s department', $school_name, $department_name));
elseif (isset($school_name)):
	$this->set('description_for_layout', __('%1$s school information for teachers, students and parents', $school_name));
endif;

$this->start('additionalStyle');
?>
.navbar-static-top{
margin-bottom: 0px;
}
<?php
$this->end();

$this->start('beforeContainer');
$latest_post = $this->requestAction(array('controller' => 'posts', 'action' => 'latest'));

if ($latest_post):
	?>
	<div class="jumbotron">
		<div class="container">
			<h1><?php echo h(__('Latest news')); ?></h1>

			<h2><?php h($latest_post['Post']['title']); ?></h2>

			<p>
				<?php
				if ($latest_post['Post']['summary']):
					echo h($latest_post['Post']['summary']);
				else:
					echo $this->Text->truncate($latest_post['Post']['body'], 500);
				endif;
				?>
			</p>

			<p><?php echo $this->Html->link(__('Read more'), array('controller' => 'posts', 'action' => 'view', $latest_post['Post']['id'], Inflector::slug($latest_post['Post']['title'])), array('class' => 'btn btn-primary btn-lg', 'role' => 'buttom')); ?></p>
		</div>
	</div>
<?php
endif;
$this->end();
?>

<div class="row">
	<div class="col-md-4">
		<h2><?php echo h(__('Account')); ?></h2>
		<?php
		if ($logged_in):
			?>
			<p><?php echo h(__('You\'re logged in as %1$s', $current_user['username'])); ?></p>
			<div class="row">
				<div
					class="col-sm-12 col-md-6"><?php echo $this->Html->link(__('Profile'), array('controller' => 'users', 'action' => 'profile'), array('class' => 'btn btn-primary')); ?></div>
				<div
					class="col-sm-12 col-md-6"><?php echo $this->Html->link(__('Logout'), array('controller' => 'users', 'action' => 'logout'), array('class' => 'btn btn-danger')); ?></div>
			</div>
		<?php
		else:
			?>
			<div class="row">
				<div
					class="col-sm-12 col-md-6"><?php echo $this->Html->link(__('Login'), array('controller' => 'users', 'action' => 'login'), array('class' => 'btn btn-primary')); ?></div>
				<div
					class="col-sm-12 col-md-6"><?php echo $this->Html->link(__('Register'), array('controller' => 'users', 'action' => 'register'), array('class' => 'btn btn-primary')); ?></div>
			</div>
		<?php
		endif;
		?>
	</div>
	<div class="col-md-4">
		<?php
		$upcoming_events = $this->requestAction(array('controller' => 'events', 'action' => 'index'));
		?>
		<h2><?php echo h(__n('Upcoming event', 'Upcoming events', count($upcoming_events))); ?></h2>
		<table class="table">
			<tr>
				<th><?php echo h(__('Event')); ?></th>
				<th><?php echo h(__('When')); ?></th>
			</tr>
			<? foreach ($upcoming_events as $event): ?>
				<tr>
					<td><?php echo $this->Html->link($event['Event']['title'], array('controller' => 'events', 'action' => 'view', $event['Event']['id'])); ?></td>
					<td><?php echo h($this->Time->niceShort($event['Event']['start'], 'Europe/Amsterdam')); ?></td>
				</tr>
			<? endforeach; ?>
		</table>
		<a href="<?php echo $this->App->url(array('controller' => 'events', 'action' => 'index')); ?>" role="button" class="btn btn-default"><?php echo h(__('List')); ?></a>
	</div>
	<div class="col-md-4">
		<?php
		$absent_teachers = $this->requestAction(array('controller' => 'teachers', 'action' => 'absent'));
		?>
		<h2><?php echo h(__n('Absent teacher', 'Absent teachers', count($absent_teachers))); ?></h2>

		<p><?php h(__('Absent teachers for the 7 following days')); ?></p>
		<table class="table">
			<tr>
				<th><?php echo h(__('Date')); ?></th>
				<th><?php echo h(__('Teacher')); ?></th>
			</tr>
			<? foreach ($absent_teachers as $report): ?>
				<tr>
					<td><?php echo h($this->Time->i18nFormat($report['AbsenceReport']['date'], '%A', 'Europe/Amsterdam')); ?></td>
					<td><?php echo $this->Html->link(($report['AffectedTeacher']['name']) ? $report['AffectedTeacher']['name'] : $report['AffectedTeacher']['abbreviation'], array('controller' => 'teachers', 'action' => 'view', $report['AbsenceReport']['teacher_id'])); ?></td>
				</tr>
			<? endforeach; ?>
		</table>
		<p><?php h(__n('%d absent teacher report', '%d absent teachers reports', count($absent_teachers), count($absent_teachers))); ?></p>
	</div>
	<?php
	if ($logged_in):
		$user_class_subscriptions = $this->requestAction(array('controller' => 'users', 'action' => 'class_subscriptions'));
		?>
		<div class="col-md-4">
			<h2><?php echo(__n('Class subscription', 'Class subscriptions', count($user_class_subscriptions))); ?></h2>

			<p><?php echo(__('This table shows the classes you\'ve subscribed to')); ?></p>
			<table class="table">
				<tr>
					<th><?php echo h(__('Class')); ?></th>
				</tr>
				<? foreach ($user_class_subscriptions as $classroomSubscription): ?>
					<tr>
						<td><?php echo $this->Html->link($classroomSubscription['Class']['name'], array('controller' => 'schedule', 'action' => 'index', 'class' => $classroomSubscription['Class']['id'])); ?></td>
					</tr>
				<? endforeach; ?>
			</table>
		</div>
	<?php endif; ?>
	<div class="col-md-4">
		<?php
		$classrooms_available = $this->requestAction(array('controller' => 'classrooms', 'action' => 'available', 'limit' => 5));
		?>
		<h2><?php echo h(__n('Available classroom', 'Available classrooms', count($classrooms_available))); ?></h2>

		<p><?php echo h(__n('Classroom available at: %s', 'Classrooms available at: %s', count($classrooms_available), $this->Time->i18nFormat(time(), '%X', null, 'Europe/Amsterdam'))) ?></p>
		<table class="table">
			<tr>
				<th><?php echo h(__('Classroom')); ?></th>
				<th><?php echo h(__('Title')); ?></th>
			</tr>
			<? foreach ($classrooms_available as $classroom): ?>
				<tr>
					<td><?php echo $this->Html->link($classroom['Classroom']['code'], array('controller' => 'classroom', 'action' => 'view', $classroom['Classroom']['id'])) ?></td>
					<td><?php echo h(@$classroom['MappingInformation']['ClassroomDetails']['title']); ?></td>
				</tr>
			<? endforeach; ?>
		</table>
		<a href="<?php echo $this->App->url(array('controller' => 'classrooms', 'action' => 'available')); ?>" role="button" class="btn btn-default"><?php echo h(__('Go to complete list')); ?></a>
	</div>
	<div class="col-md-4">
		<h2><?php echo h(__('Feedback')); ?></h2>
		<?php
		echo $this->Form->create('Feedback', array(
			'inputDefaults' => array(
				'div'   => 'form-group',
				'label' => false,
				'class' => 'form-control'
			),
			'class'         => 'form-horizontal',
			'url'           => array(
				'controller' => 'feedback',
				'action'     => 'add'
			),
		));

		echo $this->Form->input('body', array('rows' => '5'));

		echo $this->Form->submit(__('Add'), array(
			//'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-default'
		));

		echo $this->Form->end()
		?>
	</div>
	<div class="col-md-4"><?php echo $this->element('latest_comments'); ?></div>
</div>