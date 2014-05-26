<?php
$this->Title->setPageTitle(__('Vending machine'));

$this->Title->addCrumbs(array(
	array('controller' => 'vending_machine')
));

echo $this->element('page_header');
?>
<div class="row">
	<div class="col-lg-6">
		<section class="panel panel-info">
			<header class="panel-heading">
				<?php echo h(__('Transactions')); ?>
			</header>
			<div class="panel-body" id="transactions-body">
				<?php echo h(__('Your latest transactions')); ?>
			</div>
			<table class="table">
				<thead>
				<tr>
					<th><?php echo h(__('Timestamp')); ?></th>
					<th><?php echo h(__('Card')); ?></th>
					<th><?php echo h(__('Amount')); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php
				$transactions = $this->requestAction(array('controller' => 'transactions'));

				foreach ($transactions as $transaction):
					?>
					<tr class="<?php echo ($transaction['Transaction']['amount'] < 0) ? 'danger' : '' ?>">
						<td><?php echo h($this->Time->i18nFormat($transaction['Transaction']['created'], '%c', null, 'Europe/Amsterdam')); ?></td>
						<td><?php echo h(($transaction['UsedCard']['name']) ? $transaction['UsedCard']['name'] : __('None')); ?></td>
						<td><?php echo h($transaction['Transaction']['amount']); ?></td>
					</tr>
				<?php
				endforeach;
				?>
				</tbody>
			</table>

			<a href="<?php echo Router::url(array('controller' => 'transactions')); ?>">
				<footer class="panel-footer announcement-bottom">
					<div class="row">
						<div class="col-xs-10">
							<?php echo h(__('View transactions')); ?>
						</div>
						<div class="col-xs-2 text-right">
							<i class="fa fa-arrow-circle-right"></i>
						</div>
					</div>
				</footer>
			</a>
		</section>
	</div>
	<div class="col-lg-offset-3 col-lg-3">
		<?php
		$balance = $this->requestAction(array('controller' => 'user_balances', 'action' => 'balance'));

		echo $this->element(
			'announcement',
			array(
				'type'    => 'info',
				'heading' => $amount = $balance,
				'text'    => __('Balance'),
				'icon'    => 'fa-eur',
				'link'    => array(
					'url'   => array('controller' => 'user_balances', 'action' => 'balance'),
					'label' => __('View balance')
				)
			)
		)
		?>
	</div>
</div>