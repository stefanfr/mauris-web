<?
$this->Title->addSegment(__('Users'));
$this->Title->setPageTitle(__('Profile'));

$this->Title->addCrumbs(array(
	null,
	$this->here,
));

$this->set('schema_type_for_layout', 'ProfilePage');
?>
<h1><?php echo $this->Title->getPageTitle() ?></h1>
<div itemprop="about" itemscope itemtype="http://schema.org/Person">
	<b><?=h(__('Name'))?></b>: <span itemprop="name"><?php echo $this->App->buildName($user_account['User']); ?></span>
</div>
<b><?=__('Email address')?>:</b> <?php echo $user_account['User']['email']; ?>
