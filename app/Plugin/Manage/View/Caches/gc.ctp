<?php
$this->Html->addCrumb(__('Caches'), array('action' => 'index')); 
$this->Html->addCrumb(__('Clear caches'),
    $this->here
);
?>
<h1><?php echo h(__('Garbage collect cache'))?></h1>
<?php
echo $this->Form->create('Cache', array(
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
<div class="form-group">
	<?php
	echo $this->Form->submit(__('Collect garbage'), array(
		'div' => 'col col-md-9 col-md-offset-3',
		'class' => 'btn btn-default'
	));
	?>
</div>
<?php
echo $this->Form->end();
?>
