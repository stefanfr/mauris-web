<?php
/**
 * @var $organizations
 */

$this->Title->setPageTitle(__('Organizations'));

$this->Title->addCrumbs(array(
	array('action' => 'index')
));

$this->set('title_for_layout', $this->Title->getPageTitle());

echo $this->element('page_header');
echo $this->element('button/add');
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
			<td><?php echo $this->element('button/edit', array('id' => $organization['School']['id'])) ?></td>
			<td><?php echo $this->element('button/delete', array('id' => $organization['School']['id'])) ?></td>
		</tr>
	<? endforeach ?>
	</tbody>
</table>

<?php echo $this->element('pagination') ?>