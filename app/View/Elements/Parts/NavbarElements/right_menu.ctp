<?php

App::uses('AuthComponent', 'Controller/Component');

$this->startIfEmpty('right_menu');
if (AuthComponent::user('id')):
?>
<p class="navbar-text navbar-right">
	<?php
	echo h(__(
		'Logged in as %s',
		$this->App->buildName(AuthComponent::user())
	));
	?>
</p>
<?php
else:
	echo $this->Form->create('User', array(
		'inputDefaults' => array(
			'label' => false,
			'div'   => array(
				'class' => 'form-group'
			),
			'class' => 'form-control'
		),
		'url'           => array(
			'plugin'     => null,
			'controller' => 'users',
			'action'     => 'login'
		),
		'class'         => 'navbar-form navbar-right'
	));
	echo $this->Form->input('username', array(
		'placeholder' => __('Username')
	));
	echo $this->Form->input('password', array(
		'placeholder' => _('Password')
	));
	echo $this->Form->end(array(
		'div'   => 'form-group',
		'class' => 'btn btn-default'
	));
endif;

$this->end();