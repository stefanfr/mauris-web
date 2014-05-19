<?php
/**
 * @var $id int
 */

echo $this->Html->link(
	'<span class="glyphicon glyphicon-pencil"></span>',
	array('action' => 'edit', $id),
	array('class' => 'btn btn-default', 'escape' => false)
);
