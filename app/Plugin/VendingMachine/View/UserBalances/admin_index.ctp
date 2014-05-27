<?php
/**
 * @var $user_balances array
 */
$this->Title->addSegment(__('Vending machine'));
$this->Title->setPageTitle(__('User balances'));

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
			<th><?php echo h(__('View')); ?></th>
			<th><?php echo h(__('User')); ?></th>
			<th><?php echo h(__('Credit')); ?></th>
			<th><?php echo h(__('Change')); ?></th>
			<th><?php echo h(__('Remove')); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($user_balances as $user_balance): ?>
		<tr class="<?php echo ($user_balance['UserBalance']['balance'] < 0) ? 'danger' : '' ?>">
			<td><?php echo $this->element('button/view', array('id' => $user_balance['UserBalance']['user_id'])) ?></td>
			<td><?php echo $this->Html->link($user_balance['User']['username'], array('plugin' => null, 'controller' => 'users', 'action' => 'view', $user_balance['User']['id'])) ?></td>
			<td><?php echo h($user_balance['UserBalance']['balance']) ?></td>
			<td><?php echo $this->element('button/edit', array('id' => $user_balance['UserBalance']['user_id'])) ?></td>
			<td><?php echo $this->element('button/delete', array('id' => $user_balance['UserBalance']['user_id'])) ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php
echo $this->element('pagination');

echo $this->element('button/back', array('url' => array('controller' => 'vending_machine')));
?>
