<?
$title = __('Edit %1$s', $organization['School']['name']);

$this->Html->addCrumb(__('Organizations'), array('action' => 'index'));
$this->Html->addCrumb($title, $this->here);

$this->set('title_for_layout', $title . ' - ' . __('Organizations'));
?>
<h1><?=$title?></h1>
<?=
$this->Form->create('School', array(
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-3 control-label'
		),
		'wrapInput' => 'col col-md-9',
		'class' => 'form-control'
	),
	'class' => 'form-horizontal'
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
	echo $this->Form->submit('Edit', array(
		'div' => 'col col-md-9 col-md-offset-3',
		'class' => 'btn btn-default'
	));
	?>
</div>
<?php
echo $this->Form->end();
?>
