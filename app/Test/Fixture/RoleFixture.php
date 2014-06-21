<?php

class RoleFixture extends CakeTestFixture {

	public $import  = 'Role';
	public $records = array(
		array(
			'id'           => 1,
			'system_alias' => 'admin',
			'title'        => 'Admin',
		),
		array(
			'id'           => 2,
			'system_alias' => 'anonymous',
			'title'        => 'Anonymous',
		)
	);

}