<?php

App::uses('ElementTestCase', 'Lib');

class DeleteButtonElementTest extends ElementTestCase {

	public function testButtonWithId() {
		$output = $this->View->element('button/view', array('id' => 10));

		$urlMatcher = array(
			'tag'        => 'a',
			'attributes' => array(
				'href' => Router::url(array('action' => 'view', '10'))
			)
		);
		$this->assertTag($urlMatcher, $output);
	}

}