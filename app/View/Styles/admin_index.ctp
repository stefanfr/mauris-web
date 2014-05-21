<?php
/**
 * @var $styles array
 */
$this->Title->setPageTitle(__('Styles'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
));

echo $this->Html->link(
	__('%1$s Add', '<span class="fa fa-plus"></span>'),
	array('action' => 'add'),
	array('class' => 'btn btn-default', 'escape' => false)
)
?>
<h1><?php echo h($this->Title->getPageTitle()) ?></h1>
<table class="table">
	<thead>
	<tr>
		<th><?php echo h(__('Name')) ?></th>
		<th><?php echo h(__('Change')) ?></th>
		<th><?php echo h(__('Remove')) ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($styles as $style): ?>
		<tr>
			<td>
				<?php
				echo $this->Html->link(
					$style['Style']['title'],
					array(
						'action' => 'view',
						$style['Style']['id'],
						Inflector::slug($style['Style']['title'])
					)
				)
				?>
			</td>
			<td>
				<?php
				echo $this->Html->link(
					'<span class="glyphicon glyphicon-pencil"></span>',
					array('action' => 'edit', $style['Style']['id']),
					array('class' => 'btn btn-default', 'escape' => false)
				)
				?>
			</td>
			<td><?php echo $this->element('button/delete', array('id' => $style['Style']['id'])) ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>