<?php

class LanguageFixture extends CakeTestFixture {

	public $import  = 'Language';
	public $records = array(
		array(
			'id'   => 1,
			'code' => 'eng',
			'name' => 'English'
		),
		array(
			'id'   => 2,
			'code' => 'nld',
			'name' => 'Dutch'
		)
	);

}