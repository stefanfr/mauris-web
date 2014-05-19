<?
$this->Title->addSegment(__('Schedule'));
$this->Title->setPageTitle($subject_title) ? $subject_title : $subject_abbreviation);

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	$this->here
));
?>
<div itemscope itemtype="http://schema.org/EducationEvent">
  <h1 itemprop="name"><?php echo h($this->Title->getPageTitle())) ?></h1>

    <meta itemprop="startDate" content="<?=date(DateTime::ISO8601, $this->get('entry_date_start'))?>">
    <meta itemprop="endDate" content="<?=date(DateTime::ISO8601, $this->get('entry_date_end'))?>">
    <?=h(__('Period'))?>: <?=$this->get('entry_period');?> (<?=$this->Time->i18nFormat($this->Time->format('c', $this->get('entry_date_start'), null, 'Europe/Amsterdam'), '%X')?> - <?=$this->Time->i18nFormat($this->Time->format('c', $this->get('entry_date_end'), null, 'Europe/Amsterdam'), '%X')?>)
    <div itemprop="attendee" itemscope itemtype="http://schema.org/Organization">
        <?=h(__('Class'))?>: <a itemprop="url" href="<?=$this->get('class_url')?>">
            <span itemprop="name"><?=$this->get('class_name')?></span>
        </a>
    </div>
    <? if ($this->get('teacher_name') != false):?>
    <div itemprop="performer" itemscope itemtype="http://schema.org/Person">
        <?=h(__('Teacher'))?>: <a itemprop="url" href="<?=$this->get('teacher_url')?>">
            <span itemprop="name"><?=$this->get('teacher_name')?></span>
        </a>
    </div>
    <? endif;?>
  <div itemprop="location" itemscope itemtype="http://schema.org/Place">
      <meta itemprop="alternateName" content="<?=$this->get('classroom_code')?>">
    <?=h(__('Classroom'))?>: <a itemprop="url" href="<?=$this->get('classroom_url')?>">
    <span itemprop="name"><?=($this->get('classroom_name') != false) ? $this->get('classroom_name') : $this->get('classroom_code')?></span>
    </a>
  </div>
    <?if ($this->get('entry_cancelled')):?>
    <link itemprop="eventStatus" href="http://schema.org/EventCancelled"/>Status: Lesuitval
    <?endif;?>
    <h2><?=h(__('Assignments'))?></h2>
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