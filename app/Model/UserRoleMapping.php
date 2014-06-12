<?php

/**
 * Class UserRoleMapping
 *
 * @property Role Role
 */
class UserRoleMapping extends AppModel {

    public $belongsTo = array(
        'User', 'School', 'Department', 'Role'
    );

	public $actsAs = array(
		'OrganizationOwned'
	);
    
}
