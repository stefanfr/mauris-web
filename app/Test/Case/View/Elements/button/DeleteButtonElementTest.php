<?php

App::uses('ElementTestCase', 'Lib');

class DeleteButtonElementTest extends ElementTestCase {

	public function testButtonWithText() {
		$text = '<b>bla</b>';

		$output = $this->View->element('button/delete', array('text' => $text));

		$this->assertContains($text, $output);

		$urlMatcher = array(
			'tag'        => 'form',
			'attributes' => array(
				'action' => Router::url(array('action' => 'delete'))
			)
		);
		$this->assertTag($urlMatcher, $output);
	}

	public function testButtonWithAndText() {
		$text = '<b>bla</b>';

		$output = $this->View->element('button/delete', array('id' => 10, 'text' => $text));

		$this->assertContains($text, $output);

		$urlMatcher = array(
			'tag'        => 'form',
			'attributes' => array(
				'action' => Router::url(array('action' => 'delete', '10'))
			)
		);
		$this->assertTag($urlMatcher, $output);
	}

	public function testButtonWithId() {
		$output = $this->View->element('button/delete', array('id' => 10));

		$urlMatcher = array(
			'tag'        => 'form',
			'attributes' => array(
				'action' => Router::url(array('action' => 'delete', '10'))
			)
		);
		$this->assertTag($urlMatcher, $output);
	}

}