<?php

App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('GravatarHelper', 'View/Helper');

class ProgressHelperTest extends CakeTestCase {

    public function setUp() {
		parent::setUp();
		
		$Controller = new Controller();
		$View = new View($Controller);
		$this->Gravatar = new GravatarHelper($View);
    }

    public function testGravatar() {
		$email = 'example@example.com';
		
		$result = $this->Gravatar->gravatar($email);
		$this->assertContains(md5($email), $result);
    }

}