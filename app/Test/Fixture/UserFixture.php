<?php

class UserFixture extends CakeTestFixture {

	public $import  = 'User';
	public $records = array(
		array(
			'id'        => null,
			'username'  => 'Henkie123',
			'password'  => '*****',
			'email'     => 'henkie@example.com',
			'created'   => '2014-07-12 15:12:13',
			'created'   => '2014-07-13 18:35:42',
			'firstname' => 'Henk',
			'surname'   => 'Janssen',
			'nickname'  => 'Henkie123',
			'active'    => 1
		),
		array(
			'id'        => null,
			'username'  => 'MrInactive',
			'password'  => '*****',
			'email'     => 'inactive@example.com',
			'created'   => '2014-08-12 15:12:13',
			'created'   => '2014-07-13 18:35:42',
			'firstname' => 'Inactive',
			'surname'   => null,
			'nickname'  => null,
			'active'    => 0
		)
	);

}
