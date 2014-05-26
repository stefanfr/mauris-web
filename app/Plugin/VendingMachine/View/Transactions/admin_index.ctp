<?php
/**
 * @var $transactions array
 */
$this->Title->addSegment(__('Vending machine'));
$this->Title->setPageTitle(__('Transactions'));

$this->Title->addCrumbs(array(
	array('controller' => 'vending_machine'),
	array('action' => 'index'),
));

echo $this->element('page_header');

echo $this->element('button/add');
?>
<table class="table">
	<thead>
		<tr>
			<th><?php echo h(__('Date')); ?></th>
			<th><?php echo h(__('Credit account')); ?></th>
			<th><?php echo h(__('Amount')); ?></th>
			<th><?php echo h(__('Remove')); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($transactions as $transaction): ?>
		<tr class="<?php echo ($transaction['Transaction']['amount'] < 0) ? 'danger'  : '' ?>">
			<td><?php echo $this->Html->link($transaction['Transaction']['created'], array('action' => 'view', $transaction['Transaction']['id'])) ?></td>
			<td><?php echo $this->Html->link($transaction['CreditAccount']['User']['username'], array('plugin' => null, 'controller' => 'users', 'action' => 'view', $transaction['CreditAccount']['User']['id'])) ?></td>
			<td><?php echo h($transaction['Transaction']['amount']) ?></td>
			<td><?php echo $this->element('button/delete', array('id' => $transaction['Transaction']['id'])) ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php echo $this->element('pagination'); ?>