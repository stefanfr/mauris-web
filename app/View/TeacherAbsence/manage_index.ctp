<?
$this->Title->setPageTitle(__('Teacher absence'));

$this->Title->addCrumbs(array(
	array('action' => 'index')
));

echo $this->element('page_header');

echo $this->element('button/add');
?>
<table class="table">
	<thead>
	<tr>
		<th><?= h(__('Date')) ?></th>
		<th><?= h(__('Teacher')) ?></th>
		<th><?= h(__('Change')) ?></th>
		<th><?= h(__('Remove')) ?></th>
	</tr>
	</thead>
	<tbody>
	<? foreach ($absence_reports as $absence_report): ?>
		<tr>
			<td><?= h($this->Time->niceShort($absence_report['TeacherAbsenceReport']['date'])) ?></td>
			<td>
				<?=
				$this->Html->link(
					$absence_report['AffectedTeacher']['name'] ? $absence_report['AffectedTeacher']['name'] : $absence_report['AffectedTeacher']['abbreviation'],
					array(
						'controller' => 'teacher',
						'action'     => 'view',
						$absence_report['TeacherAbsenceReport']['teacher_id']
					)
				)
				?>
			</td>
			<td><?php echo $this->element('button/edit', array('id' => $absence_report['TeacherAbsenceReport']['id'])) ?></td>
			<td><?php echo $this->element('button/delete', array('id' => $absence_report['TeacherAbsenceReport']['id'])) ?></td>
		</tr>
	<? endforeach; ?>
	</tbody>
</table>

<?php echo $this->element('pagination') ?>