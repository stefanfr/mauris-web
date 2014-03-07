<?
$this->Html->addCrumb(__('Sitemaps'), array('action' => 'index')); 
$this->Html->addCrumb(__('Schedule entries'), $this->here); 

$this->set('title_for_layout', __('Sitemaps') . ' - ' . __('Schedule entries'));
?>
<h1><?=__('Sitemaps')?></h1>
<h2><?=__('Schedule entries')?></h2>
<ul>
    <?php foreach ($schedule_entries as $entry):?>
    <li>
        <?=$this->Html->link(array('controller' => 'schedule', 'action' => 'view', $entry['ScheduleEntry']['id']))?>
    </li>
    <?php endforeach; ?>
</li>
