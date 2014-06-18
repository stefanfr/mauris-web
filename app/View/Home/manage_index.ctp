<?= $this->Menu->item($this->Html->link(__('Edit organizations'), array('controller' => 'organizations', 'action' => 'index'))); ?>
<?= $this->Menu->item($this->Html->link(__('Edit posts'), array('controller' => 'posts', 'action' => 'index'))); ?>
<?= $this->Menu->item($this->Html->link(__('Edit schedule'), array('controller' => 'schedule'))); ?>
<?= $this->Menu->item($this->Html->link(__('Report teacher absence'), array('controller' => 'teacher_absence', 'action' => 'add'))); ?>
<?php echo $this->Menu->item($this->Html->link(__('Assign a teacher to a user'), array('controller' => 'user_teacher_mappings', 'action' => 'add'))); ?>
<?php echo $this->Menu->item($this->Html->link(__('Edit assignments'), array('controller' => 'assignments'))); ?>