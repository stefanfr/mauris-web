<?
$this->Html->addCrumb('Rooster', array('controller' => 'schedule', 'action' => 'index')); 
$this->Html->addCrumb('Simpel', array('controller' => 'schedule', 'action' => 'index', 'type' => 'simple'));

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
<?=$this->Html->link('Kalender rooster', array_merge(array('controller' => 'schedule', 'action' => 'index', 'type' => 'calendar'), $target))?>
<? foreach ($this->get('entries') as $entry): ?>
<div itemscope itemtype="http://schema.org/EducationEvent">
    <a itemprop="url" href="<?=Router::url(array('controller' => 'schedule', 'action' => 'view', $entry['id']))?>">
    <h1 itemprop="name"><?=(isset($entry['subject_title'])) ? $entry['subject_title'] : $entry['subject_abbreviation']?></h1>
  </a>

    <meta itemprop="startDate" content="<?=date('c', $entry['start'])?>">
    <meta itemprop="endDate" content="<?=date('c', $entry['end'])?>">
    Lesuur: <?=$entry['period'];?> (<?=strftime('%X', $entry['start'])?> - <?=strftime('%X', $entry['end'])?>)
    <div itemprop="attendee" itemscope itemtype="http://schema.org/Organization">
        Klas: <a itemprop="url" href="<?=$entry['class_url']?>">
            <span itemprop="name"><?=$entry['class_name']?></span>
        </a>
    </div>
    <? if (isset($entry['teacher_name'])):?>
    <div itemprop="performer" itemscope itemtype="http://schema.org/Person">
        Docent: <a itemprop="url" href="<?=$entry['teacher_url']?>">
            <span itemprop="name"><?=$entry['teacher_name']?></span>
        </a>
    </div>
    <? endif;?>
  <div itemprop="location" itemscope itemtype="http://schema.org/Place">
      <meta itemprop="alternateName" content="<?=$entry['classroom_code']?>">
    Lokaal: <a itemprop="url" href="<?=$entry['classroom_url']?>">
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