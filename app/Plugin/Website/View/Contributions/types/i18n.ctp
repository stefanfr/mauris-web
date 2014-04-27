<?php
$this->Title->addSegment(__('Contributions'));
$this->Title->addSegment(__('Contribute'));
$this->Title->setPageTitle(__('I18n'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	array('action' => 'contribute'),
	$this->here
));
?>
<h1><?php echo h($this->Title->getPageTitle())?></h1>
<div class="row">
	<main class="col-lg-9">
		<div class="well">
			<?php echo h(__('Nothing yet?'))?>
		</div>
	</main>
	<div class="col-lg-3">
		
	</div>
</div>