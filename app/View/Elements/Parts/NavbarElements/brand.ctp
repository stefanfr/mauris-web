<?php
$this->startIfEmpty('brand');
echo $this->Html->link($this->Title->getSiteTitle(),
	'/', array('class' => 'navbar-brand')
);
$this->end();