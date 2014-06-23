<?php

class PostsControllerTest extends ControllerTestCase {

	public $fixtures = array(
		'Post', 'Language', 'Style', 'Organization', 'Department', 'CakeSession', 'Role', 'UserRoleMapping',
		'Permission', 'PermissionRoleMapping', 'User', 'Comment'
	);

	public function testIndex() {
		$result = $this->testAction('/posts', array('method' => 'get'));

		$this->assertInternalType('array', $this->vars['posts']);
	}

	public function testOverview() {
		$result = $this->testAction(Router::url(array('controller' => 'posts', 'action' => 'overview')), array('method' => 'get'));

		$this->assertInternalType('array', $this->vars['posts']);
		$this->assertEqual($this->vars['_serialize'], array('posts'));
	}

	public function testOverviewLimit() {
		$result = $this->testAction(
			Router::url(array(
				'controller' => 'posts',
				'action'     => 'overview',
				'?'          => array(
					'limit' => 1
				)
			)),
			array('method' => 'get')
		);

		debug($this->vars['posts']);

		$this->assertInternalType('array', $this->vars['posts']);
		$this->assertCount(1, $this->vars['posts']);
	}


}
