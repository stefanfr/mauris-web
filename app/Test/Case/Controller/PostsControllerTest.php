<?php

class PostsControllerTest extends ControllerTestCase {

	public $fixtures = array('Post', 'Language', 'Style', 'Organization', 'Department', 'CakeSession', 'Role', 'UserRoleMapping', 'Permission', 'PermissionRoleMapping');

	public function testIndex() {
		$result = $this->testAction('/posts');

		$this->assertInternalType('array', $this->vars['posts']);
	}

}
