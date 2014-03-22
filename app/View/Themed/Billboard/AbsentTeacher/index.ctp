<? if (!empty($reports)): ?>
<table class="table">
    <tr>
        <th><?=__('Date')?></th>
        <th><?=__('Teacher')?></th>
    </tr>
    <? foreach ($reports as $report): ?>
    <tr>
        <td><?=h($this->Time->niceShort($report['TeacherAbsenceReport']['date'], 'Europe/Amsterdam'))?></td>
        <td><?=$this->Html->link(($report['AffectedTeacher']['name']) ? $report['AffectedTeacher']['name'] : $report['AffectedTeacher']['abbreviation'], array('controller' => 'teacher', 'action' => 'view', $report['TeacherAbsenceReport']['teacher_id']))?></td>
    </tr>
    <? endforeach; ?>
</table>
<? else: ?>
<span><?=__('No teachers are reported as absent at the moment')?></span>
<? endif; ?>
