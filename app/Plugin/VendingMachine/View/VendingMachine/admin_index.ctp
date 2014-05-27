<?php
$this->Title->setPageTitle(__('Vending machine'));

$this->Title->addCrumbs(array(
	array('controller' => 'vending_machine')
));
?>
<div class="row">
	<div class="col-lg-2 col-sm-12">
		<ul>
			<li><?php echo $this->Html->link(__('User balances'), array('controller' => 'user_balances')); ?></li>
			<li><?php echo $this->Html->link(__('Cards'), array('controller' => 'cards')); ?></li>
			<li><?php echo $this->Html->link(__('Transactions'), array('controller' => 'transactions')); ?></li>
		</ul>
	</div>
	<div class="col-lg-3">
		<?php
		$cardStats = $this->requestAction(array('controller' => 'cards', 'action' => 'stats'));

		echo $this->element(
			'announcement',
			array(
				'type'    => 'info',
				'heading' => $amount = $cardStats['amount'],
				'text'    => __n('Card', 'Cards', $amount),
				'icon'    => 'fa-credit-card',
				'link'    => array(
					'url'   => array('controller' => 'cards'),
					'label' => __('View cards')
				)
			)
		)
		?>
	</div>
	<div class="col-lg-3">
		<?php
		$transactionStats = $this->requestAction(array('controller' => 'transactions', 'action' => 'stats'));

		echo $this->element(
			'announcement',
			array(
				'type'    => 'info',
				'heading' => $amount = $transactionStats['amount'],
				'text'    => __n('Transaction', 'Transactions', $amount),
				'icon'    => 'fa-money',
				'link'    => array(
					'url'   => array('controller' => 'transactions'),
					'label' => __('View transactions')
				)
			)
		)
		?>
	</div>
</div>
<?php echo $this->element('button/back', array('url' => array('plugin' => null, 'controller' => 'home'))); ?>