<?php
$this->Html->addCrumb(__('Caches'), $this->here); 

if ($can_delete) {
	echo $this->Html->link('Clear caches', array('action' => 'clear'));
}
if ($can_read):
	echo $this->DynList->addSource('cache', array('action' => 'view', 'ID'));
?>
<table class="table" data-source="cache">
	<tr>
		<th><?php echo h(__('Name'))?></th>
		<th><?php echo h(__('View'))?></th>
	</tr>
<?php
	foreach ($configurations as $configuration):
?>
	<tr data-id="<?php echo $configuration?>">
		<td>
			<span data-class-collapsed="fa fa-plus" data-class-expanded="fa fa-minus"  data-expand></span>
			<?php echo h($configuration)?>
			<div class="panel-content" data-content></div>
		</td>
		<td><?php echo $this->Html->link($configuration, array('action' => 'view', $configuration))?></td>
	</tr>
<?php
	endforeach;
?>
</table>
<?php
endif;
?>
