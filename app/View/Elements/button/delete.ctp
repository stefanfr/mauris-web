<?php
/**
 * @var $id int
 */

echo $this->Html->link(
	'<span class="glyphicon glyphicon-remove"></span>',
	array('action' => 'delete', $id),
	array('class' => 'btn btn-danger', 'escape' => false)
);
