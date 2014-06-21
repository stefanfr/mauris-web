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
			'published'     => '1',
			'created'       => '2014-08-03 15:20:00'
		)
	);

}
