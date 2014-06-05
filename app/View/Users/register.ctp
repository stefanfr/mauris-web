<?php
$this->Title->addSegment(__('Users'));
$this->Title->setPageTitle(__('Register'));

$this->Title->addCrumbs(array(
	null,
	$this->here
));

echo $this->element('page_header');
?>
<div class="users form">
	<?php echo $this->ModelForm->create('User'); ?>
	<fieldset>
		<legend><?php echo h(__('Credentials')); ?></legend>
		<?php
		echo $this->Form->input('username', array('label' => __('Username')));
		echo $this->Form->input('password', array('label' => __('Password')));
		?>
	</fieldset>
	<fieldset>
		<legend><?php echo h(__('Contact')); ?></legend>
		<?php echo $this->Form->input('email', array('label' => 'Email')); ?>
	</fieldset>
	<fieldset>
		<legend><?php echo h(__('Personal details')); ?></legend>
		<?php echo $this->Form->input('firstname', array('label' => __('Firstname'))); ?>
		<?php echo $this->Form->input('middlename', array('label' => __('Middlename'))); ?>
		<?php echo $this->Form->input('surname', array('label' => __('Surname'))); ?>
		<?php echo $this->Form->input('nickname', array('label' => __('Nickname'))); ?>
	</fieldset>
	<?php
	echo $this->Form->submit(__('Register'), array(
		'div'   => 'col col-md-9 col-md-offset-3',
		'class' => 'btn btn-default'
	));

	echo $this->Form->end();
	?>
</div>