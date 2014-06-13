<?php

$this->Title->setPageTitle(__('Teacher assignments'));

$this->Title->addCrumbs(array(
	array('controller' => 'user_teacher_mappings'),
));

echo $this->element('page_header');

echo $this->element('button/add');
?>
	<table class="table">
		<thead>
		<tr>
			<th><?php echo h(__('Teacher')); ?></th>
			<th><?php echo h(__('User')); ?></th>
			<th><?php echo h(__('Remove')); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($user_teacher_mappings as $user_teacher_mapping): ?>
			<tr>
				<td><?php echo $this->Html->link(__($user_teacher_mapping['Teacher']['name']), array('controller' => 'teachers', 'action' => 'view', $user_teacher_mapping['Teacher']['id'])); ?></td>
				<td><?php echo $this->Html->link($this->App->buildName($user_teacher_mapping['User']), array('controller' => 'users', 'action' => 'profile', 'manage' => false, $user_teacher_mapping['User']['id']), array('target' => '_blank')); ?></td>
				<td><?php echo $this->element('button/delete', array('id' => $user_teacher_mapping['UserTeacherMapping']['id'])); ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

<?php echo $this->element('pagination'); ?>