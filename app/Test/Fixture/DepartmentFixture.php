<?php

class DepartmentFixture extends CakeTestFixture {

	public $import  = 'Department';
	public $records = array(
		array(
			'id'        => 1,
			'school_id' => 1,
			'name'      => 'Test department',
			'logo'      => 'department.jpg'
		)
	);

}