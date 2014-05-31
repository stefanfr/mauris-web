<?php

$this->Title->addSegment(__('Role assignments'));
$this->Title->setPageTitle(__('Students'));

$this->Title->addCrumbs(array(
	array('controller' => 'user_role_mappings'),
	array('action' => 'index')
));

echo $this->element('page_header');

echo $this->element('button/add');
?>
	<table class="table">
		<thead>
		<tr>
			<th><?php echo h(__('Name')); ?></th>
			<th><?php echo h(__('Remove')); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($students as $student): ?>
			<tr>
				<td><?php echo $this->Html->link($this->App->buildName($student['User']), array('controller' => 'users', 'action' => 'profile', 'manage' => false, $student['User']['id']), array('target' => '_blank')); ?></td>
				<td><?php echo $this->element('button/delete', array('id' => $student['UserRoleMapping']['id'])); ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

<?php
echo $this->element('pagination');

echo $this->element('button/back', array('url' => array('controller' => 'user_role_mappings')));
?>