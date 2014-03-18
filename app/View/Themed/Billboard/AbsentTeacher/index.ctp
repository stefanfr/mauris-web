<? if (!empty($reports)): ?>
<table class="table">
    <tr>
        <th><?=__('Date')?></th>
        <th><?=__('Teacher')?></th>
    </tr>
    <? foreach ($reports as $report): ?>
    <tr>
        <th><?=h($this->Time->i18nFormat($report['TeacherAbsenceReport']['date'], '%A', 'Europe/Amsterdam'))?></th>
        <th><?=$this->Html->link(($report['AffectedTeacher']['name']) ? $report['AffectedTeacher']['name'] : $report['AffectedTeacher']['abbreviation'], array('controller' => 'teacher', 'action' => 'view', $report['TeacherAbsenceReport']['teacher_id']))?></th>
    </tr>
    <? endforeach; ?>
</table>
<? else: ?>
<span><?=__('No teachers are reported as absent at the moment')?></span>
<? endif; ?>
