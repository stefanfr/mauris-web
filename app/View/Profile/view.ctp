<?
$this->Title->addSegment(__('Profiles'));
$this->Title->setPageTitle(__('View'));

$this->Title->addCrumbs(array(
	null,
	$this->here,
));

$this->set('schema_type_for_layout', 'ProfilePage');
?>
<h1><?php echo $this->Title->getPageTitle() ?></h1>
<div itemprop="about" itemscope itemtype="http://schema.org/Person">
<b><?=h(__('Name'))?></b>:<span itemprop="name">
<? if (trim($fullname)):?>
<?=$fullname?><?=($nickname) ? ' (' . $nickname . ')' : ''?> 
<? else: ?>
<?=$nickname?> 
<? endif; ?>
</span>
</div>
<b><?=__('Email address')?>:</b> <?=$system_email?>
