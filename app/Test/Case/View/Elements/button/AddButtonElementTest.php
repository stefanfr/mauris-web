<?php

App::uses('ElementTestCase', 'Lib');

class AddButtonElementTest extends ElementTestCase {

	public function testButton() {
		$output = $this->View->element('button/add');

		$urlMatcher = array(
			'tag'        => 'a',
			'attributes' => array(
				'href' => Router::url(array('action' => 'add'))
			)
		);
		$this->assertTag($urlMatcher, $output);
	}

}