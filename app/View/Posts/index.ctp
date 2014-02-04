<h1>Blog posts</h1>
<p><?php echo $this->Html->link('Add Post', array('action' => 'add')); ?></p>
<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th><?php echo __('Title'); ?></th>
			<th><?php echo __('Actions'); ?></th>
			<th><?php echo __('Created'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php if(empty($posts)): ?>
			<tr>
				<td colspan="4" align="center"><?php echo __('No posts found'); ?></td>
			</tr>
		<?php else: ?>
			<?php foreach ($posts as $post): ?>
			<tr>
				<td><?php echo $post['Post']['id']; ?></td>
				<td>
					<?php
						echo $this->Html->link(
							$post['Post']['title'],
							array('action' => 'view', $post['Post']['id'])
						);
					?>
				</td>
				<td>
					<?php
						echo $this->Form->postLink(
							'Delete',
							array('action' => 'delete', $post['Post']['id']),
							array('confirm' => 'Are you sure?')
						);
					?>
					<?php
						echo $this->Html->link(
							'Edit', array('action' => 'edit', $post['Post']['id'])
						);
					?>
				</td>
				<td>
					<?php echo $post['Post']['created']; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
