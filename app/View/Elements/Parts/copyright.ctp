<?php
$this->startIfEmpty('copyright');

echo h(__('Copyright %d-%d ©', 2013, date('Y')));
?>
 - 
<?php
echo $this->Html->link(
	'CVO-Technologies',
	'http://cvo-technologies.com/',
	array('target' => '_BLANK')
);
?>
 & 
<?php
echo $this->Html->link(
	'Dev App ("0100Dev")',
	'http://devapp.nl/',
	array('target' => '_BLANK')
);

$this->end();
?>