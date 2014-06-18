<?php
/**
 * @var $available_classrooms array
 */
$this->Title->addSegment(__('Classrooms'));
$this->Title->setPageTitle(__('Available classrooms'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	array('action' => 'available')
));

echo $this->element('page_header');
?>
<p><?php echo h(__n('There is one classroom available at: %1$ss', 'There are %2$d classrooms available at: %1$s', $this->Paginator->param('count'), $this->Time->i18nFormat(time(), '%X', null, 'Europe/Amsterdam'), $this->Paginator->param('count'))) ?></p>
<table class="table">
	<tr>
		<th><?php echo h(__('Classroom')) ?></th>
		<th><?php echo h(__('Title')) ?></th>
	</tr>
	<?php foreach ($available_classrooms as $classroom): ?>
		<tr>
			<td><?php echo $this->Html->link($classroom['Classroom']['code'], array('controller' => 'classrooms', 'action' => 'view', $classroom['Classroom']['id'])) ?></td>
			<td><?php echo((isset($classroom['Classroom']['title'])) ? h($classroom['Classroom']['title']) : '&nbsp;') ?></td>
		</tr>
	<?php endforeach; ?>
</table>

<?php echo $this->element('pagination'); ?>