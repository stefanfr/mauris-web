<?php
/**
 * @var $user array
 */

$this->Title->addSegment(__('Users'));
$this->Title->setPageTitle(__('Change %1$s', $user['User']['username']));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	array($user['User']['id'])
));
?>
<h1><?php echo h($this->Title->getPageTitle()) ?></h1>
<?php
echo $this->Form->create('User', array(
	'inputDefaults' => array(
		'div'       => 'form-group',
		'label'     => array(
			'class' => 'col col-md-3 control-label'
		),
		'wrapInput' => 'col col-md-9',
		'class'     => 'form-control'
	),
	'class'         => 'form-horizontal'
));
?>
<?php
echo $this->Form->input('username');
echo $this->Form->input('nickname');
?>
<fieldset>
	<legend><?php echo h(__('Personal details')) ?></legend>
	<?php
	echo $this->Form->input('firstname');
	echo $this->Form->input('middlename');
	echo $this->Form->input('lastname');
	?>
</fieldset>
<fieldset>
	<legend><?php echo h(__('Contact details')) ?></legend>
	<?php
	echo $this->Form->input('email', array('placeholder' => __('Bla')));
	echo $this->Form->input('system_email', array('placeholder' => __('Email address for system emails for developers and administrators')));
	?>
</fieldset>
<fieldset>
	<legend><?php echo h(__('Authentication details')) ?></legend>
	<?php
	echo $this->Form->input('password');
	?>
</fieldset>
<div class="form-group">
	<?php
	echo $this->Form->submit('Change', array(
		'div'   => 'col col-md-9 col-md-offset-3',
		'class' => 'btn btn-default'
	));
	?>
</div>
<?php
echo $this->Form->end();
?>
