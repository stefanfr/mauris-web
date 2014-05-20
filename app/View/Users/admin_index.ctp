<?php
/**
 * @var $users array
 */

$this->Title->setPageTitle(__('Users'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
));

echo $this->element('page_header');
?>
<table class="table">
	<thead>
	<tr>
		<th><?php echo h(__('Name')) ?></th>
		<th><?php echo h(__('Change')) ?></th>
		<th><?php echo h(__('Remove')) ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($users as $user): ?>
		<tr>
			<td>
				<?php
				echo $this->Html->link(
					$user['User']['username'],
					array(
						'action' => 'view',
						$user['User']['id'],
						Inflector::slug($user['User']['username'])
					)
				)
				?>
			</td>
			<td><?php echo $this->element('button/edit', array('id' => $user['User']['id'])) ?></td>
			<td><?php echo $this->element('button/delete', array('id' => $user['User']['id'])) ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<?php echo $this->element('pagination') ?>