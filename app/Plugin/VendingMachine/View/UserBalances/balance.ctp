<?php
/**
 * @var $balance float
 */

$this->Title->addSegment(__('Vending machine'));
$this->Title->setPageTitle(__('Credit account'));

$this->Title->addCrumbs(array(
	array('controller' => 'vending_machine'),
	array('action' => 'index'),
));

echo $this->element('page_header');
?>
<style>
	.balance {
		font-size: 5em;
	}
</style>
<div class="row">
	<div class="col-lg-4 col-md-offset-4">
		<div class="balance"><?php echo h(__('Balance:')); ?></div>
	</div>
	<div class="col-lg-4">
		<div class="balance"><span class="fa fa-euro"></span> <?php echo $this->Number->currency($balance, 'EUR', array('before' => false)); ?></div>
	</div>
</div>