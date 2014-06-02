<?php
/**
 * @var $id int
 */

echo $this->Html->link(
	'<span class="fa fa-arrow-left"></span> ' . h(__('Back')),
	(isset($url)) ? $url : array('action' => 'index'),
	array('class' => 'btn btn-default', 'escape' => false)
);
