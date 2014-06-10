<?php if (!empty($absent_teachers)): ?>
	<table class="table">
		<tr>
			<th><?php echo h(__('Date')); ?></th>
			<th><?php echo h(__('Teacher')); ?></th>
		</tr>
		<?php foreach ($absent_teachers as $report): ?>
			<tr>
				<td><?php echo h($this->Time->i18nFormat($report['AbsenceReport']['date'], '%A', 'Europe/Amsterdam')); ?></td>
				<td><?php echo $this->Html->link(($report['AffectedTeacher']['name']) ? $report['AffectedTeacher']['name'] : $report['AffectedTeacher']['abbreviation'], array('controller' => 'teacher', 'action' => 'view', $report['AbsenceReport']['teacher_id'])); ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
<?php else: ?>
	<span><?php echo h(__('No teachers are reported as absent at the moment')); ?></span>
<?php endif; ?>
