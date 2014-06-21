<?php

App::uses('ElementTestCase', 'Lib');

class BackButtonElementTest extends ElementTestCase {

	public function testButton() {
		$output = $this->View->element('button/back');

		$urlMatcher = array(
			'tag'        => 'a',
			'attributes' => array(
				'href' => Router::url(array('action' => 'index'))
			)
		);
		$this->assertTag($urlMatcher, $output);
	}

	public function testButtonWithUrl() {
		$route = array(
			'controller' => 'index',
			'action'     => 'index'
		);

		$output = $this->View->element(
			'button/back',
			array(
				'url' => $route
			)
		);

		$urlMatcher = array(
			'tag'        => 'a',
			'attributes' => array(
				'href' => Router::url($route)
			)
		);
		$this->assertTag($urlMatcher, $output);
	}

}