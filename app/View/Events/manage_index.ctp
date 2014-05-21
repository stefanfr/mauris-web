<?php
$this->Title->setPageTitle(__('Events'));

$this->Title->addCrumbs(array(
	array('action' => 'index')
));

echo $this->element('page_header');

echo $this->element('button/add');
?>
	<table class="table">
		<thead>
		<tr>
			<th><?php echo $this->Paginator->sort('title', __('Title')) ?></th>
			<th><?php echo $this->Paginator->sort('start', __('Begin')) ?></th>
			<th><?php echo h(__('Change')) ?></th>
			<th><?php echo h(__('Remove')) ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($events as $event): ?>
			<tr>
				<td><?php echo h($event['Event']['title']) ?></td>
				<td><?php echo h($event['Event']['start']) ?></td>
				<td><?php echo $this->element('button/edit', array('id' => $event['Event']['id'])) ?></td>
				<td><?php echo $this->element('button/delete', array('id' => $event['Event']['id'])) ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

<?php echo $this->element('pagination') ?>