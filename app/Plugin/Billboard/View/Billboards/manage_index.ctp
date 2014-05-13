<?php
/**
 * @var $billboards array
 */

debug($billboards);
?>
<table class="table">
	<thead>
		<tr>
			<th><?php echo h(__('Location')) ?></th>
			<th><?php echo h(__('Change')) ?></th>
			<th><?php echo h(__('Remove')) ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($billboards as $billboard): ?>
		<tr>
			<td>
				<?php echo h($billboard['Billboard']['location']) ?>
 			</td>
			<td>
				<?php
				echo $this->Form->postButton(
					'<span class="glyphicon glyphicon-pencil"></span>',
					array('action' => 'edit', $billboard['Billboard']['id']),
					array('class' => 'btn btn-default')
				)
				?>
			</td>
			<td>
				<?php
				echo $this->Form->postButton(
					'<span class="glyphicon glyphicon-remove"></span>',
					array('action' => 'delete', $billboard['Billboard']['id']),
					array('class' => 'btn btn-danger')
				)
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>