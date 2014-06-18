<?php

$this->Title->setPageTitle(__('Assignments'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
));

echo $this->element('page_header');

echo $this->element('button/add');
?>
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
			<td><?php echo $this->element('button/edit', array('id' => $assignment['Assignment']['id'])); ?></td>
			<td><?php echo $this->element('button/delete', array('id' => $assignment['Assignment']['id'])); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>