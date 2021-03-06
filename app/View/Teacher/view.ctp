<?
$this->Html->addCrumb(__('Teachers'), array('action' => 'index')); 
$this->Html->addCrumb(
    ($teacher['Teacher']['name']) ? $teacher['Teacher']['name'] : $teacher['Teacher']['abbreviation'],
    $this->here
);?>
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