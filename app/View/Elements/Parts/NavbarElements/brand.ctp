<?php
$this->startIfEmpty('brand');
echo $this->Html->link($this->Title->getSiteTitle(),
	$this->webroot, array('class' => 'navbar-brand')
);
$this->end();