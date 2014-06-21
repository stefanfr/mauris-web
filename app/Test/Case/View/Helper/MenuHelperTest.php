<?php

App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('MenuHelper', 'View/Helper');
App::uses('HtmlHelper', 'View/Helper');

class MenuHelperTest extends CakeTestCase {

	public function setUp() {
		parent::setUp();

		$Controller = new Controller();
		$View = new View($Controller);
		$this->Menu = new MenuHelper($View);
		$this->Html = new HtmlHelper($View);
		$this->Html->request = $this->getMock('CakeRequest');
		$this->Html->request->webroot = '';
	}

	public function testItem() {
		Router::connect('/:controller/:action/*');

		$params = array('controller' => 'index', 'action' => 'index');
		$result = $this->Menu->item($this->Html->link('Test link', $params));
		$this->assertContains(Router::Url($params), $result);
		$this->assertContains('<li', $result);
	}

}