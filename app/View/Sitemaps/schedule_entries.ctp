<?
$this->Title->addSegment(__('Sitemaps'));
$this->Title->setPageTitle(__('Schedule entries'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	$this->here
));
?>
<h1><?php echo h($this->Title->getPageTitle()) ?></h1>
<ul>
    <?php foreach ($schedule_entries as $entry):?>
    <li>
        <?=$this->Html->link(array('controller' => 'schedule', 'action' => 'view', $entry['ScheduleEntry']['id']))?>
    </li>
    <?php endforeach; ?>
</li>
