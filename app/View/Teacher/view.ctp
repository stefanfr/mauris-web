<?
$this->Title->addSegment(__('Teachers'));
$this->Title->setPageTitle(($teacher['Teacher']['name']) ? $teacher['Teacher']['name'] : $teacher['Teacher']['abbreviation']);

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	$this->here
));
?>
<h1><?php echo h($this->Title->getPageTitle()) ?></h1>
<ul class="list-group">
    <li class="list-group-item"><b><?=h(__('Name'))?>:</b> <?=($teacher['Teacher']['name']) ? $teacher['Teacher']['name'] : $teacher['Teacher']['abbreviation']?></li>
    <li class="list-group-item"><b><?=h(__('Account'))?>:</b>
        <ul class="list-group">
        <? foreach ($teacher['UserMappings'] as $userMapping): ?>
        <li class="list-group-item"><?=$this->Html->link($userMapping['User']['username'], array('controller' => 'profile', 'action' => 'view', $userMapping['user_id']))?></li>
        <? endforeach; ?>
        </ul>
    </li>
</ul>

<?debug($teacher);?>