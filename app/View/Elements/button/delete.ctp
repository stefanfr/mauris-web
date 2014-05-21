<?php
/**
 * @var $id int
 */

echo $this->Form->postLink(
	'<span class="glyphicon glyphicon-remove"></span>',
	array('action' => 'delete', $id),
	array('class' => 'btn btn-danger', 'escape' => false),
	__('Are you sure you want to remove this?')
);
