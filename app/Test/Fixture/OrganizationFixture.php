<?php

class OrganizationFixture extends CakeTestFixture {

	public $import  = 'School';
	public $records = array(
		array(
			'id'       => 1,
			'name'     => 'Mauris Systems',
			'logo'     => 'nothing.jpg',
			'website'  => 'example.org',
			'hostname' => 'mauris.example.org'
		)
	);

}
