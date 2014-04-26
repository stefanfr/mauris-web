<?php
$this->Html->addCrumb(__('Caches'), $this->here); 

if ($can_delete) {
	echo $this->Html->link('Clear caches', array('action' => 'clear'));
}
?>
<ul>
<?php
if ($can_read) {
	foreach ($configurations as $configuration):
?>
	<li><?php echo $this->Html->link($configuration, array('action' => 'view', $configuration))?></li>
<?php
	endforeach;
}
?>
</ul>