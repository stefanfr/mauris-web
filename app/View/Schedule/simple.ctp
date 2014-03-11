<?
$this->Html->addCrumb(__('Schedule'), array('controller' => 'schedule', 'action' => 'index')); 
$this->Html->addCrumb(__('Simple'), array('controller' => 'schedule', 'action' => 'index', 'type' => 'simple'));

$target = array();
if ($this->get('target_class_id')) {
    $target['class'] = (int) $this->get('target_class_id');
}
if ($this->get('target_teacher_id')) {
    $target['teacher'] = (int) $this->get('target_teacher_id');
}
if ($this->get('target_classroom_id')) {
    $target['classroom'] = (int) $this->get('target_classroom_id');
}
?>
<?=$this->start('rightMenu'); ?>
<form class="navbar-form navbar-right" method="POST">
	<select name="teacher" id="selector-teacher" class="form-control" onchange="this.form.submit()">
			<option disabled selected><?=__('Teacher'); ?></option>
		<?php foreach ($this->get('teachers') as $teacher): ?>
			<option value="<?=$teacher['id']?>"><?=($teacher['name']) ? $teacher['name'] : $teacher['abbreviation']?></option>
		<?php endforeach; ?>
	</select>
	<select name="class" id="selector-class" class="form-control" onchange="this.form.submit()">
			<option disabled selected><?=__('Class'); ?></option>
		<?php foreach ($this->get('classes') as $class): ?>
			<option value="<?=$class['id']?>"><?=$class['name']?></option>
		<?php endforeach; ?>
	</select>
</form>
<?=$this->end(); ?>
<?=$this->Html->link(__('Calendar schedule'), array_merge(array('controller' => 'schedule', 'action' => 'index', 'type' => 'calendar'), $target))?>
<? foreach ($this->get('entries') as $entry): ?>
<div itemscope itemtype="http://schema.org/EducationEvent">
    <a itemprop="url" href="<?=Router::url(array('controller' => 'schedule', 'action' => 'view', $entry['id']))?>">
    <h1 itemprop="name"><?=(isset($entry['subject_title'])) ? $entry['subject_title'] : $entry['subject_abbreviation']?></h1>
  </a>

    <meta itemprop="startDate" content="<?=date('c', $entry['start'])?>">
    <meta itemprop="endDate" content="<?=date('c', $entry['end'])?>">
    <?=h(__('Period'))?>: <?=$entry['period'];?> (<?=strftime('%X', $entry['start'])?> - <?=strftime('%X', $entry['end'])?>)
    <div itemprop="attendee" itemscope itemtype="http://schema.org/Organization">
        <?=h(__('Class'))?>: <a itemprop="url" href="<?=$entry['class_url']?>">
            <span itemprop="name"><?=$entry['class_name']?></span>
        </a>
    </div>
    <? if (isset($entry['teacher_name'])):?>
    <div itemprop="performer" itemscope itemtype="http://schema.org/Person">
        <?=h(__('Teacher'))?>: <a itemprop="url" href="<?=$entry['teacher_url']?>">
            <span itemprop="name"><?=$entry['teacher_name']?></span>
        </a>
    </div>
    <? endif;?>
  <div itemprop="location" itemscope itemtype="http://schema.org/Place">
      <meta itemprop="alternateName" content="<?=$entry['classroom_code']?>">
    <?=h(__('Classroom'))?>: <a itemprop="url" href="<?=$entry['classroom_url']?>">
    <span itemprop="name"><?=(isset($entry['classroom_name'])) ? $entry['classroom_name'] : $entry['classroom_code']?></span>
    </a>
  </div>
    <?if ($entry['cancelled']):?>
    <link itemprop="eventStatus" href="http://schema.org/EventCancelled"/>Status: Lesuitval
    <?endif;?>
</div>    
<? endforeach; ?>
<ul class="pagination">
<?=$this->Paginator->numbers(array('first' => 2, 'last' => 2, 'currentClass' => 'active', 'currentTag' => 'span'))?>
</ul>