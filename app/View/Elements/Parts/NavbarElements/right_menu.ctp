<?php

if ($logged_in):
	$dropdownText = h(__(
		'Logged in as %s',
		$this->App->buildName($current_user)
	));
else:
	$dropdownText = h(__('Account'));
endif;

$this->startIfEmpty('right_menu');
?>
	<ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $dropdownText; ?> <b class="caret"></b></a>
			<ul class="dropdown-menu">
				<?php
				if ($logged_in):
					?>
					<li><?php echo $this->Html->link(__('Profile'), array('plugin' => false, 'website' => false, 'controller' => 'users', 'action' => 'profile')); ?></li>
					<li class="divider"></li>
					<li><?php echo $this->Html->link(__('Logout'), array('plugin' => false, 'website' => false, 'controller' => 'users', 'action' => 'logout')); ?></li>
					<?php
				else:
					?>
					<li><?php echo $this->Html->link(__('Login'), array('plugin' => false, 'website' => false, 'controller' => 'users', 'action' => 'login')); ?></li>
					<li><?php echo $this->Html->link(__('Register'), array('plugin' => false, 'website' => false, 'controller' => 'users', 'action' => 'register')); ?></li>
					<?php
				endif;
				?>
			</ul>
		</li>
	</ul>
<?php

$this->end();
