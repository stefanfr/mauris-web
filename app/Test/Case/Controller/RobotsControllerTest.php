<?php

class RobotsControllerTest extends ControllerTestCase {

	public $fixtures = array(
		'User', 'Organization', 'Department', 'Style', 'Language', 'CakeSession', 'Role', 'UserRoleMapping',
		'PermissionRoleMapping', 'Permission'
	);

	public function testRobotsTxtRoute() {
		$this->testAction('/robots.txt', array('return' => 'view', 'method' => 'get'));
	}

	public function testRobotsTxtValidity() {
		$lines = $this->testAction(
			Router::url(array('controller' => 'robots', 'ext' => 'txt')),
			array('return' => 'view', 'method' => 'get')
		);

		foreach (explode(PHP_EOL, $lines) as $line) {
			$line = trim($line);
			if ((!$line) || ($line[0] == '#')) {
				continue;
			}

			list($type) = explode(':', $line, 2);
			$this->assertContains($type, array('User-Agent', 'Disallow', 'Allow', 'Sitemap'));
		}
	}

}
