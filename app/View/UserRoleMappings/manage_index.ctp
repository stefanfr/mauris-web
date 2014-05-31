<?php

$this->Title->setPageTitle(__('Role assignments'));

$this->Title->addCrumbs(array(
	array('controller' => 'user_role_mappings'),
));

echo $this->element('page_header');
?>
	<ul>
		<li><?php echo $this->Html->link(__('Students'), array('controller' => 'students')); ?></li>
	</ul>
<?php echo $this->element('button/add'); ?>
	<table class="table">
		<thead>
		<tr>
			<th><?php echo h(__('Name')); ?></th>
			<th><?php echo h(__('Role')); ?></th>
			<th><?php echo h(__('Remove')); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($user_role_mappings as $user_role_mapping): ?>
			<tr>
				<td><?php echo $this->Html->link($this->App->buildName($user_role_mapping['User']), array('controller' => 'users', 'action' => 'profile', 'manage' => false, $user_role_mapping['User']['id']), array('target' => '_blank')); ?></td>
				<td><?php echo $this->Html->link(__($user_role_mapping['Role']['title']), array('controller' => 'roles', 'action' => 'view', $user_role_mapping['Role']['id']), array('target' => '_blank')); ?></td>
				<td><?php echo $this->element('button/delete', array('id' => $user_role_mapping['UserRoleMapping']['id'])); ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

<?php echo $this->element('pagination'); ?>