<?php
/**
 * @var $cards array
 */
$this->Title->addSegment(__('Vending machine'));
$this->Title->setPageTitle(__('Cards'));

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
		<th><?php echo h(__('User')); ?></th>
		<th><?php echo h(__('Code')); ?></th>
		<th><?php echo h(__('Change')); ?></th>
		<th><?php echo h(__('Remove')); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($cards as $card): ?>
		<tr>
			<td><?php echo $this->Html->link($card['UserBalance']['User']['username'], array('plugin' => null, 'controller' => 'users', 'action' => 'view', $card['UserBalance']['User']['id'])); ?></td>
			<td><?php echo h($card['Card']['code']); ?></td>
			<td><?php echo $this->element('button/edit', array('id' => $card['Card']['id'])); ?></td>
			<td><?php echo $this->element('button/delete', array('id' => $card['Card']['id'])); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php
echo $this->element('pagination');

echo $this->element('button/back', array('url' => array('controller' => 'vending_machine')));
?>