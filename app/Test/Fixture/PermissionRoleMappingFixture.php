<?php

class PermissionRoleMappingFixture extends CakeTestFixture {

	public $fields = array(
		'id'            => array('type' => 'integer', 'key' => 'primary'),
		'role_id'       => 'integer',
		'permission_id' => 'integer',
		'school_id'     => 'integer',
		'department_id' => 'integer',
		'scope'         => 'text',
		'preference'    => 'integer',
		'actions'       => 'text',
		'allow'         => 'integer'
	);

	public $records = array(
		array(
			'id'            => 1,
			'role_id'       => 1,
			'permission_id' => 1,
			'scope'         => 'system,school,department,own',
			'preference'    => 9999,
			'actions'       => 'create,read,update,delete',
			'allow'         => 1
		),
		array(
			'id'            => 2,
			'role_id'       => 2,
			'permission_id' => 1,
			'scope'         => 'system,school,department,own',
			'preference'    => 9999,
			'actions'       => 'read',
			'allow'         => 1
		)
	);

}