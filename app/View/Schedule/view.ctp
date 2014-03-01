<?
$this->Html->addCrumb('Rooster', array('controller' => 'schedule', 'action' => 'index'));
$this->Html->addCrumb(($subject_title) ? $subject_title : $subject_abbreviation, $this->here); 

?>
<div itemscope itemtype="http://schema.org/EducationEvent">
  <h1 itemprop="name"><?=($this->fetch('subject_title') != false) ? $this->fetch('subject_title') : $this->fetch('subject_abbreviation')?></h1>

    <meta itemprop="startDate" content="<?=date('c', $this->get('entry_date_start'))?>">
    <meta itemprop="endDate" content="<?=date('c', $this->get('entry_date_end'))?>">
    Lesuur: <?=$this->get('entry_period');?> (<?=strftime('%X', $this->get('entry_date_start'))?> - <?=strftime('%X', $this->get('entry_date_end'))?>)
    <div itemprop="attendee" itemscope itemtype="http://schema.org/Organization">
        Klas: <a itemprop="url" href="<?=$this->get('class_url')?>">
            <span itemprop="name"><?=$this->get('class_name')?></span>
        </a>
    </div>
    <? if ($this->get('teacher_name') != false):?>
    <div itemprop="performer" itemscope itemtype="http://schema.org/Person">
        Docent: <a itemprop="url" href="<?=$this->get('teacher_url')?>">
            <span itemprop="name"><?=$this->get('teacher_name')?></span>
        </a>
    </div>
    <? endif;?>
  <div itemprop="location" itemscope itemtype="http://schema.org/Place">
      <meta itemprop="alternateName" content="<?=$this->get('classroom_code')?>">
    Lokaal: <a itemprop="url" href="<?=$this->get('classroom_url')?>">
    <span itemprop="name"><?=($this->get('classroom_name') != false) ? $this->get('classroom_name') : $this->get('classroom_code')?></span>
    </a>
  </div>
    <?if ($this->get('entry_cancelled')):?>
    <link itemprop="eventStatus" href="http://schema.org/EventCancelled"/>Status: Lesuitval
    <?endif;?>
    <h2>Opgaves</h2>
    <?
    foreach ($this->get('assignments') as $assignment):
        $state = '';
        $states = array();
        if (in_array('make', $assignment['state'])) {
            $states[] = __('maken in de les');
            $state = 'make';
        }
        if (in_array('done', $assignment['state'])) {
            $states[] = _('moet af zijn');
            $state = 'done';
        }
        if (in_array('check', $assignment['state'])) {
            $states[] = __('wordt na gekeken');
            $state = 'check';
        }
    ?>
    <h3><span class="assignment-state-<?=$state?>"><?=$assignment['title']?></span> - <?=  implode(' & ', $states)?></h3>
    <?=$assignment['description']?>
    <?endforeach;?>
</div>