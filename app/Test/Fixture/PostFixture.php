<?php

class PostFixture extends CakeTestFixture {

	public $import  = 'Post';
	public $records = array(
		array(
			'id'            => 1,
			'school_id'     => 1,
			'department_id' => 1,
			'user_id'       => 1,
			'title'         => 'Woo news!',
			'body'          => 'Like the news?',
			'summary'       => 'You must read this!',
			'published'     => 1,
			'created'       => '2014-08-03 15:20:00'
		),
		array(
			'id'            => 2,
			'school_id'     => null,
			'department_id' => null,
			'user_id'       => 1,
			'title'         => 'System post :o',
			'body'          => 'Hello there!',
			'summary'       => 'Yet another system wide post',
			'published'     => 1,
			'created'       => '2014-09-03 15:20:00'
		),
		array(
			'id'            => 3,
			'school_id'     => null,
			'department_id' => null,
			'user_id'       => 1,
			'title'         => 'System post :o (another one)',
			'body'          => 'Hello there!',
			'summary'       => 'Yet another system wide post',
			'published'     => 1,
			'created'       => '2014-07-03 15:20:00'
		)
	);

}
