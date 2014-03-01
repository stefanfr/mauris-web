<h1><?=h(__('Update comment'))?></h1>
<?php
echo $this->Form->create('Comment', array(
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-3 control-label'
		),
		'wrapInput' => 'col col-md-9',
		'class' => 'form-control'
	),
	'class' => 'form-horizontal'
	));
?>
<?=$this->Form->input('body', array('rows' => '3'))?>
<?=$this->Form->input('id', array('type' => 'hidden'))?>
<div class="form-group">
	<?php echo $this->Form->submit('Aanpassen', array(
		'div' => 'col col-md-9 col-md-offset-3',
		'class' => 'btn btn-default'
	)); ?>
</div>
<?=$this->Form->end()?>
