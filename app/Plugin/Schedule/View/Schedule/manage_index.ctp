<?php
/**
 * @var $schedule_entries array
 */
$this->Title->setPageTitle(__('Schedule'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
));

echo $this->element('page_header');
?>
<table class="table">
	<thead>
		<tr>
			<th><?php echo $this->Paginator->sort('date', __('Date')); ?></th>
			<th><?php echo $this->Paginator->sort('period', __('Period')); ?></th>
			<th><?php echo $this->Paginator->sort('class_id', __('Class')); ?></th>
			<th><?php echo $this->Paginator->sort('subject_id', __('Subject')); ?></th>
			<th><?php echo $this->Paginator->sort('teacher_id', __('Teacher')); ?></th>
			<th><?php echo h(__('Change')) ?></th>
			<th><?php echo h(__('Remove')) ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($schedule_entries as $schedule_entry): ?>
		<?php echo $this->Html->tag('tr', null, ($schedule_entry['ScheduleEntry']['cancelled']) ? array('class' => 'danger') : array()) ?>
			<td><?php echo $schedule_entry['ScheduleEntry']['date'] ?></td>
			<td><?php echo $schedule_entry['GivenInPeriod']['period'] ?></td>
			<td><?php echo $schedule_entry['GivenToClass']['name'] ?></td>
			<td><?php echo $schedule_entry['GivenSubject']['abbreviation'] ?></td>
			<td><?php echo $schedule_entry['GivenByTeacher']['name'] ?></td>
			<td><?php echo $this->element('button/edit', array('id' => $schedule_entry['ScheduleEntry']['id'])) ?></td>
			<td><?php echo $this->element('button/delete', array('id' => $schedule_entry['ScheduleEntry']['id'])) ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<?php echo $this->element('pagination') ?>