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
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Register'); ?></legend>
        <?php echo $this->Form->input('username');
        echo $this->Form->input('password');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Register')); ?>
</div>