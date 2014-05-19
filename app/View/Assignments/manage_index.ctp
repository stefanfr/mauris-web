<?php

$this->Title->setPageTitle(__('Assignments'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
));
?>
<h1><?php echo h($this->Title->getPageTitle()) ?></h1>
<table class="table">
	<thead>
		<tr>
			<th><?php echo h(__('Name')) ?></th>
			<th><?php echo h(__('Change'))?></th>
			<th><?php echo h(__('Remove'))?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($assignments as $assignment): ?>
		<tr>
			<td>
				<?php
				echo $this->Html->link(
					$assignment['Assignment']['title'],
					array(
						'action' => 'view',
						$assignment['Assignment']['id'],
						Inflector::slug($assignment['Assignment']['title'])
					)
				)
				?>
			</td>
			<td>
				<?php
				echo $this->Form->postButton(
					'<span class="glyphicon glyphicon-pencil"></span>',
					array('action' => 'edit', $assignment['Assignment']['id']),
					array('class' => 'btn btn-default')
				)
				?>
			</td>
			<td>
				<?php
				echo $this->Form->postButton(
					'<span class="glyphicon glyphicon-remove"></span>',
					array('action' => 'delete', $assignment['Assignment']['id']),
					array('class' => 'btn btn-danger')
				)
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>