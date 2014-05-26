<?php
$this->Title->setPageTitle(__('Vending machine'));

$this->Title->addCrumbs(array(
	array('controller' => 'home')
));
?>
<ul>
	<li><?php echo $this->Html->link(__('Credit accounts'), array('controller' => 'credit_accounts')); ?></li>
	<li><?php echo $this->Html->link(__('Cards'), array('controller' => 'cards')); ?></li>
	<li><?php echo $this->Html->link(__('Transactions'), array('controller' => 'transactions')); ?></li>
</ul>