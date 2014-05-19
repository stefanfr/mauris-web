<?php
$this->Title->addSegment(__('Feedback'));
$this->Title->setPageTitle(__('View feedback'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	array($feedback['Feedback']['id']),
));

echo $this->element('page_header');
?>
<table class="table">
	<tr>
		<th><?php echo h(__('User')) ?></th>
		<td><?php echo h(($feedback['Feedback']['user_id']) ? $feedback['ByUser']['username'] : __('Unknown')) ?></td>
	</tr>
	<tr>
		<th><?php echo h(__('Body')) ?></th>
		<td><?php echo $this->Text->autoParagraph(h($feedback['Feedback']['body'])) ?></td>
	</tr>
</table