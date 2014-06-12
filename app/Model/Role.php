<?php

class Role extends AppModel {
	
    public $displayField = 'title';

    public $hasMany = array(
        'UserRoleMapping', 'PermissionRoleMapping'
    );

	/**
	 * Get the id of a role
	 *
	 * @param $slug string System alias of the role
	 * @return int id of the role
	 */
	public function getRoleId($slug) {
		return $this->field('id', array(
			'system_alias' => $slug,
		));
	}
        
}
