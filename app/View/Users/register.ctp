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
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		?>
	</fieldset>
	<?php
	echo $this->Form->submit(__('Register'), array(
		'div'   => 'col col-md-9 col-md-offset-3',
		'class' => 'btn btn-default'
	));

	echo $this->Form->end();
	?>
</div>