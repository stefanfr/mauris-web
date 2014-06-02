<?php
/**
 * @var $id int
 */

echo $this->Html->link(
	'<span class="fa fa-eye"></span>',
	array('action' => 'view', $id),
	array('class' => 'btn btn-default', 'escape' => false)
);
