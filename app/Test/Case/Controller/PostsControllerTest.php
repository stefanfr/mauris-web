<?php

class PostsControllerTest extends ControllerTestCase {

    public function testIndex() {
        $result = $this->testAction('/posts');

		$this->assertInternalType('array', $this->vars['posts']);
    }

}
