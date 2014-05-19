<?php
/**
 * @var $schedule_entries array
 */
$this->Title->setPageTitle(__('Schedule'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
));
?>
<h1><?php echo h($this->Title->getPageTitle()) ?></h1>
<table class="table">
	<thead>
		<tr>
			<th><?php echo h(__('Date')) ?></th>
			<th><?php echo h(__('Period')) ?></th>
			<th><?php echo h(__('Class')) ?></th>
			<th><?php echo h(__('Subject')) ?></th>
			<th><?php echo h(__('Teacher')) ?></th>
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
			<td>
				<?php
				echo $this->Html->link(
					'<span class="glyphicon glyphicon-pencil"></span>',
					array('action' => 'edit', $schedule_entry['ScheduleEntry']['id']),
					array('class' => 'btn btn-default', 'escape' => false)
				)
				?>
			</td>
			<td>
				<?php
				echo $this->Html->link(
					'<span class="glyphicon glyphicon-remove"></span>',
					array('action' => 'delete', $schedule_entry['ScheduleEntry']['id']),
					array('class' => 'btn btn-danger', 'escape' => false)
				)
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<ul class="pagination">
	<?php echo $this->Paginator->numbers(array('first' => 2, 'last' => 2, 'currentClass' => 'active', 'currentTag' => 'span')) ?>
</ul>