<?php

App::uses('AppController', 'Controller');

class RobotsController extends AppController {

	public $components = array(
		'RequestHandler'
	);

	public function index() {
		$disallow = array(
			array('plugin' => 'debug_kit', 'controller' => null),
			array('admin' => true, 'controller' => null),
			array('manage' => true, 'controller' => null),
		);
		$sitemaps = array(
			array('controller' => 'sitemaps', 'ext' => 'xml')
		);

		$this->set(compact('disallow', 'sitemaps'));
	}

}