<?php
/**
 * @var $assignment array
 */

$this->Title->addSegment(__('Assignments'));
$this->Title->setPageTitle($assignment['Assignment']['title']);

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	array('action' => 'view', $assignment['Assignment']['id'], Inflector::slug($assignment['Assignment']['title'])),
));
?>

<h1><?php echo h($assignment['Assignment']['title']) ?></h1>
<table class="table">
	<tr>
		<th><?php echo h(__('Description')) ?></th>
		<td><?php echo h($assignment['Assignment']['description']) ?></td>
	</tr>
</table>

