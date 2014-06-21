<?php

class PermissionFixture extends CakeTestFixture {

	public $import  = 'Permission';
	public $records = array(
		array(
			'id'           => 1,
			'system_alias' => 'post',
			'title'        => 'Post',
		)
	);

}