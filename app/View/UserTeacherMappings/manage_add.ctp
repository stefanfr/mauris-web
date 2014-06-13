<?php

$this->Title->addSegment(__('Teacher assignments'));
$this->Title->setPageTitle(__('Add'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	array('action' => 'add'),
));

echo $this->element('page_header');

echo $this->element('button/back', array(
	'url' => array('action' => 'index')
));
?>
<br><br>
<div class="well"><span class="label label-info"><?php echo h(__('Note:')); ?></span> <?php echo h(__('The user will automatically receive the teacher role')); ?></div>
<?php
echo $this->ModelForm->create('UserTeacherMapping');

echo $this->Form->input('teacher_id');
echo $this->Form->input('user_id');
?>
<div class="form-group">
	<?php
	echo $this->Form->submit(__('Add'), array(
		'div'   => 'col col-md-9 col-md-offset-3',
		'class' => 'btn btn-default'
	));
	?>
</div>
<?php echo $this->Form->end(); ?>