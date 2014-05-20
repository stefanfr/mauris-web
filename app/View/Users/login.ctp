<?php
$this->Title->addSegment(__('Users'));
$this->Title->setPageTitle(__('Login'));

$this->Title->addCrumbs(array(
	null,
	$this->here
));

echo $this->element('page_header');
?>
<div class="users form">
	<?php
	echo $this->Session->flash('auth');

	echo $this->ModelForm->create('User');
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