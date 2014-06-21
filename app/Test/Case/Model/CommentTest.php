<?php

App::uses('Comment', 'Model');

class CommentTest extends CakeTestCase {

	public $fixtures = array(
		'Comment', 'User', 'Post'
	);

	/**
	 * @var Comment
	 */
	private $Comment;

	public function setUp() {
		parent::setUp();

		$this->Comment = ClassRegistry::init('Comment');
	}


	public function testThreadedComments() {
		$result = $this->Comment->find('threaded', array(
			'recursive' => -1
		));

		$expected = array(
			(int)0 => array(
				'Comment'  => array(
					'id'        => '1',
					'post_id'   => '1',
					'user_id'   => '1',
					'parent_id' => null,
					'lft'       => null,
					'rght'      => null,
					'body'      => 'Hello!',
					'created'   => '2007-03-18 10:39:23',
					'modified'  => '2007-03-18 10:41:31'
				),
				'children' => array(
					(int)0 => array(
						'Comment'  => array(
							'id'        => '2',
							'post_id'   => '1',
							'user_id'   => '1',
							'parent_id' => '1',
							'lft'       => null,
							'rght'      => null,
							'body'      => 'Hi?',
							'created'   => '2007-03-19 11:39:23',
							'modified'  => '2007-03-18 11:41:31'
						),
						'children' => array()
					)
				)
			)
		);

		$this->assertEqual($result, $expected);
	}

	public function testLatestComments() {
		$latestComments = $this->Comment->getLatestComments(array('system', 'organization', 'department'), 1, 1, 10);

		$expected = array(
			array(
				'id'        => '2',
				'post_id'   => '1',
				'user_id'   => '1',
				'parent_id' => '1',
				'lft'       => null,
				'rght'      => null,
				'body'      => 'Hi?',
				'created'   => '2007-03-19 11:39:23',
				'modified'  => '2007-03-18 11:41:31'
			),
			array(
				'id'        => '1',
				'post_id'   => '1',
				'user_id'   => '1',
				'parent_id' => null,
				'lft'       => null,
				'rght'      => null,
				'body'      => 'Hello!',
				'created'   => '2007-03-18 10:39:23',
				'modified'  => '2007-03-18 10:41:31'
			)
		);

		$this->assertEqual(Hash::extract($latestComments, '{n}.Comment'), $expected);
	}

}