<?php
/**
 * @var $user array
 */

$this->Title->addSegment(__('Users'));
$this->Title->setPageTitle(__('Remove %1$s', $user['User']['username']));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	array($user['User']['id'])
));

echo $this->element('page_header');
