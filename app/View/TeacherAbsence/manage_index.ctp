<?
$this->Html->addCrumb(__('Teacher absence'), array('action' => 'index'));
?>
<a class="btn btn-default" href="<?= Router::url(array('action' => 'add')) ?>">
	<span class="glyphicon glyphicon-plus"></span> <?= h(__('Add')) ?>
</a>
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
			<td>
				<a class="btn btn-default"
				   href="<?= Router::url(array('action' => 'edit', $absence_report['TeacherAbsenceReport']['id'])) ?>">
					<span class="glyphicon glyphicon-pencil"></span>
				</a>
			</td>
			<td>
				<a class="btn btn-default"
				   href="<?= Router::url(array('action' => 'remove', $absence_report['TeacherAbsenceReport']['id'])) ?>">
					<span class="glyphicon glyphicon-remove"></span>
				</a>
			</td>
		</tr>
	<? endforeach; ?>
	</tbody>
</table>

<ul class="pagination">
	<?= $this->Paginator->numbers(array('first' => 2, 'last' => 2, 'currentClass' => 'active', 'currentTag' => 'span')) ?>
</ul>