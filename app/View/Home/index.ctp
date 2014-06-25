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
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2><?php echo h(__('Account')); ?></h2>
			</div>
			<div class="panel-body">
				<?php if ($logged_in): ?>
					<p><?php echo h(__('You\'re logged in as %1$s', $current_user['username'])); ?></p>
				<?php else: ?>
					<?php
					echo $this->Form->create('User', array(
						'controller'    => 'users',
						'action'        => 'login',
						'inputDefaults' => array(
							'div'       => 'form-group',
							'label'     => array(
								'class' => 'control-label'
							),
							'class'     => 'form-control'
						)
					));

					echo $this->Form->input('username');
					echo $this->Form->input('password');
					?>
				<?php endif; ?>
			</div>
			<div class="panel-footer">
				<?php if ($logged_in): ?>
					<div class="row">
						<div
							class="col-sm-12 col-md-6"><?php echo $this->Html->link(__('Profile'), array('controller' => 'users', 'action' => 'profile'), array('class' => 'btn btn-primary')); ?></div>
						<div
							class="col-sm-12 col-md-6"><?php echo $this->Html->link(__('Logout'), array('controller' => 'users', 'action' => 'logout'), array('class' => 'btn btn-danger pull-right')); ?></div>
					</div>
				<?php else: ?>
					<div class="row">
						<?php
						echo $this->Form->submit(__('Login'), array(
							'div'   => 'col-sm-6',
							'class' => 'btn btn-primary'
						));
						echo $this->Form->end();
						?>
						<div
							class="col-sm-6"><?php echo $this->Html->link(__('Register'), array('controller' => 'users', 'action' => 'register'), array('class' => 'btn btn-primary pull-right')); ?></div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<?php
		$upcoming_events = $this->requestAction(array('controller' => 'events', 'action' => 'index'));
		?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3><?php echo h(__n('Upcoming event', 'Upcoming events', count($upcoming_events))); ?></h3>
			</div>
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
			<div class="panel-footer">
				<a href="<?php echo $this->App->url(array('controller' => 'events', 'action' => 'index')); ?>" role="button" class="btn btn-default"><?php echo h(__('List')); ?></a>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<?php
		$absent_teachers = $this->requestAction(array('controller' => 'teachers', 'action' => 'absent'));
		?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2><?php echo h(__n('Absent teacher', 'Absent teachers', count($absent_teachers))); ?></h2>
			</div>

			<div class="panel-body">
				<p><?php echo h(__('Absent teachers for the 7 following days')); ?></p>
			</div>
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
			<div class="panel-footer">
				<p><?php echo h(__n('%d absent teacher report', '%d absent teachers reports', count($absent_teachers), count($absent_teachers))); ?></p>
			</div>
		</div>
	</div>
	<?php
	if ($logged_in):
		$user_class_subscriptions = $this->requestAction(array('controller' => 'users', 'action' => 'class_subscriptions'));
		?>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2><?php echo(__n('Class subscription', 'Class subscriptions', count($user_class_subscriptions))); ?></h2>
				</div>
				<div class="panel-body">
					<p><?php echo(__('This table shows the classes you\'ve subscribed to')); ?></p>
				</div>
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
		</div>
	<?php endif; ?>
	<div class="col-md-4">
		<?php
		$classrooms_available = $this->requestAction(array('controller' => 'classrooms', 'action' => 'available', 'limit' => 5));
		?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2><?php echo h(__n('Available classroom', 'Available classrooms', count($classrooms_available))); ?></h2>
			</div>
			<div class="panel-body">
				<p><?php echo h(__n('Classroom available at: %s', 'Classrooms available at: %s', count($classrooms_available), $this->Time->i18nFormat(time(), '%X', null, 'Europe/Amsterdam'))) ?></p>
			</div>
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
			<div class="panel-footer">
				<a href="<?php echo $this->App->url(array('controller' => 'classrooms', 'action' => 'available')); ?>" role="button" class="btn btn-default"><?php echo h(__('Go to complete list')); ?></a>
			</div>
		</div>
	</div>
	<div class="col-md-4">
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
		?>
		<div class="panel panel-default">
			<div class="panel-footer">
				<h2><?php echo h(__('Feedback')); ?></h2>
			</div>
			<div class="panel-body">
				<?php echo $this->Form->input('body', array('rows' => '5')); ?>
			</div>

			<div class="panel-footer">
				<?php
				echo $this->Form->submit(__('Add'), array(
					//'div' => 'col col-md-9 col-md-offset-3',
					'class' => 'btn btn-default'
				));
				?>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
	<div class="col-md-4"><?php echo $this->element('latest_comments', array(), array('cache' => '+1 hour')); ?></div>
</div>
