<?php

echo $this->Html->link(
	__('%1$s Add', '<span class="fa fa-plus"></span>'),
	array('action' => 'add'),
	array('class' => 'btn btn-default', 'escape' => false)
);
