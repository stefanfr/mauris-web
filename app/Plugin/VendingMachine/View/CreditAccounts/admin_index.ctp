<?php
/**
 * @var $credit_accounts array
 */
$this->Title->addSegment(__('Vending machine'));
$this->Title->setPageTitle(__('Credit accounts'));

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
			<th><?php h(__('User')); ?></th>
			<th><?php h(__('Credit')); ?></th>
			<th><?php h(__('Change')); ?></th>
			<th><?php h(__('Remove')); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($credit_accounts as $credit_account): ?>
		<tr>
			<td><?php echo $this->Html->link($credit_account['User']['username'], array('plugin' => null, 'controller' => 'users', 'action' => 'view', $credit_account['User']['id'])) ?></td>
			<td><?php echo h($credit_account['CreditAccount']['credit']) ?></td>
			<td><?php echo $this->element('button/edit', array('id' => $credit_account['CreditAccount']['user_id'])) ?></td>
			<td><?php echo $this->element('button/delete', array('id' => $credit_account['CreditAccount']['user_id'])) ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php echo $this->element('pagination'); ?>