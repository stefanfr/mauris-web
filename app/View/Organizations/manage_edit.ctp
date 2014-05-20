<?
$this->Title->addSegment(__('Organizations'));
$this->Title->setPageTitle(__('Change %1$s', $organization['School']['name']));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	array($organization['School']['id'])
));

$this->set('title_for_layout', $this->Title->getPageTitle());

echo $this->element('page_header');
?>
<?=
$this->Form->create('School', array(
	'inputDefaults' => array(
		'div'       => 'form-group',
		'label'     => array(
			'class' => 'col col-md-3 control-label'
		),
		'wrapInput' => 'col col-md-9',
		'class'     => 'form-control'
	),
	'class'         => 'form-horizontal'
))
?>
<?= $this->Form->input('name') ?>
<?= $this->Form->input('logo') ?>
<?= $this->Form->input('website') ?>
<?= $this->Form->input('style_id', array('empty' => array(null => __('None')))) ?>
<?= $this->Form->input('language_id', array('empty' => array(null => __('Default')))) ?>
<?= $this->Form->input('hostname', (($hostname_editable) ? null : array('disabled' => 'disabled'))) ?>
<?= $this->Form->input('id', array('type' => 'hidden')) ?>
<div class="form-group">
	<?php
	echo $this->Form->submit(__('Change'), array(
		'div'   => 'col col-md-9 col-md-offset-3',
		'class' => 'btn btn-default'
	));
	?>
</div>
<?php
echo $this->Form->end();
?>
