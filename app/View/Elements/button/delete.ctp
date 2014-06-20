<?php
/**
 * @var $id int
 */

$route = array('action' => 'delete');
if (isset($id)) {
	$route[] = $id;
}

echo $this->Form->postLink(
	((isset($text)) ? $text . ' ' : '') . '<span class="glyphicon glyphicon-remove"></span>' ,
	$route,
	array('class' => 'btn btn-danger', 'escape' => false),
	__('Are you sure you want to remove this?')
);
