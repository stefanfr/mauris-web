<?php
/**
 * @var $organizations
 */

$this->Title->addSegment(__('Organizations'));
$this->Title->setPageTitle(__('Add organization'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	array('action' => 'add')
));


$this->set('title_for_layout', $this->Title->getPageTitle());
?>
<h1><?php echo $this->Title->getPageTitle() ?></h1>
<?php
echo $this->Form->create('School', array(
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
echo $this->Form->input('name');
echo $this->Form->input('website');
?>
<fieldset>
	<legend><?php echo h(__('Appearance')) ?></legend>
	<?php
	echo $this->Form->input('logo');
	echo $this->Form->input('style_id', array('empty' => array(null => __('None'))));
	echo $this->Form->input('language_id', array('empty' => array(null => __('Default'))));
	?>
</fieldset>
<fieldset>
	<legend><?php echo h(__('Technical details')) ?></legend>
	<?php echo $this->Form->input('hostname') ?>
</fieldset>
<?php echo $this->Form->input('id', array('type' => 'hidden')) ?>
<div class="form-group">
	<?php
	echo $this->Form->submit(__('Add'), array(
		'div'   => 'col col-md-9 col-md-offset-3',
		'class' => 'btn btn-default'
	));
	?>
</div>
<?php
echo $this->Form->end();
?>
