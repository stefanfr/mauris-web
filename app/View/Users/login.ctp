<div class="users form">
	<?php
	echo $this->Session->flash('auth');

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
    <fieldset>
	    <legend><?php echo h(__('Please enter your username and password')) ?></legend>
	    <?php
	    echo $this->Form->input('username');
        echo $this->Form->input('password');
	    ?>
    </fieldset>
	<?php
	echo $this->Form->submit(__('Login'), array(
		'div'   => 'col col-md-9 col-md-offset-3',
		'class' => 'btn btn-default'
	));
	echo $this->Form->end();
	?>

</div>