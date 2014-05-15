<?php
/**
 * @var $organizations
 */

$this->Title->setPageTitle(__('Organizations'));

$this->Title->addCrumbs(array(
	array('action' => 'index')
));

$this->set('title_for_layout', $this->Title->getPageTitle());
?>
<h1><?php echo h($this->Title->getPageTitle()) ?></h1>
<?php
echo $this->Html->link(
	__('%1$s Add', '<span class="fa fa-plus"></span>'),
	array('action' => 'add'),
	array('class' => 'btn btn-default', 'escape' => false)
)
?>
<table class="table">
	<thead>
	<tr>
		<th><?php echo h(__('Name')) ?></th>
		<th><?php echo h(__('Change')) ?></th>
		<th><?php echo h(__('Remove')) ?></th>
	</tr>
	</thead>
	<tbody>
	<? foreach ($organizations as $organization): ?>
		<tr>
			<td><?php echo $organization['School']['name'] ?></td>
			<td>
				<?php
				echo $this->Html->link(
					'<span class="glyphicon glyphicon-pencil"></span>',
					array('action' => 'edit', $organization['School']['id']),
					array('class' => 'btn btn-default', 'escape' => false)
				)
				?>
			</td>
			<td>
				<?php
				echo $this->Html->link(
					'<span class="glyphicon glyphicon-remove"></span>',
					array('action' => 'delete', $organization['School']['id']),
					array('class' => 'btn btn-danger', 'escape' => false)
				)
				?>
			</td>
		</tr>
	<? endforeach ?>
	</tbody>
</table>

<ul class="pagination">
	<?php echo $this->Paginator->numbers(array('first' => 2, 'last' => 2, 'currentClass' => 'active', 'currentTag' => 'span')) ?>
</ul>