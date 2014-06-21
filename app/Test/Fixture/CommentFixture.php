<?php

class CommentFixture extends CakeTestFixture {

	public $import  = 'Comment';
	public $records = array(
		array(
			'id'        => 1,
			'post_id'   => 1,
			'user_id'   => 1,
			'parent_id' => null,
			'lft'       => null,
			'rght'      => null,
			'body'      => 'Hello!',
			'created'   => '2007-03-18 10:39:23',
			'modified'  => '2007-03-18 10:41:31'
		),
		array(
			'id'        => 2,
			'post_id'   => 1,
			'user_id'   => 1,
			'parent_id' => 1,
			'lft'       => null,
			'rght'      => null,
			'body'      => 'Hi?',
			'created'   => '2007-03-19 11:39:23',
			'modified'  => '2007-03-18 11:41:31'
		)
	);

}