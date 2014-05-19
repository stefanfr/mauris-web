<?php
/**
 * @var feedback array
 */
$this->Title->setPageTitle(__('Feedback'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
));

echo $this->element('page_header');
?>
	<table class="table">
		<thead>
		<tr>
			<th><?php echo $this->Paginator->sort('created', __('Date')); ?></th>
			<th><?php echo $this->Paginator->sort('user_id', __('User')); ?></th>
			<th><?php echo h(__('Summary')) ?></th>
			<th><?php echo h(__('Change')) ?></th>
			<th><?php echo h(__('Remove')) ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($feedback as $feedback_entry): ?>
			<tr>
				<td><?php echo $this->Html->link($feedback_entry['Feedback']['created'], array('action' => 'view', $feedback_entry['Feedback']['id'])) ?></td>
				<td><?php echo h(($feedback_entry['Feedback']['user_id']) ? $feedback_entry['ByUser']['username'] : __('Unknown')) ?></td>
				<td><?php echo $this->Text->autoParagraph($this->Text->truncate(h($feedback_entry['Feedback']['body']), 500)) ?></td>
				<td><?php echo $this->element('button/edit', array('id' => $feedback_entry['Feedback']['id'])) ?></td>
				<td><?php echo $this->element('button/delete', array('id' => $feedback_entry['Feedback']['id'])) ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

<?php echo $this->element('pagination') ?>