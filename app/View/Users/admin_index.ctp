<?php
/**
 * @var $users array
 */

$this->Title->setPageTitle(__('Users'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
));
?>
<h1><?php echo h($this->Title->getPageTitle()) ?></h1>
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
			<td>
				<?php
				echo $this->Html->link(
					'<span class="glyphicon glyphicon-pencil"></span>',
					array('action' => 'edit', $user['User']['id']),
					array('class' => 'btn btn-default', 'escape' => false)
				)
				?>
			</td>
			<td>
				<?php
				echo $this->Html->link(
					'<span class="glyphicon glyphicon-pencil"></span>',
					array('action' => 'delete', $user['User']['id']),
					array('class' => 'btn btn-danger', 'escape' => false)
				)
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>