<?php

/**
 * Class UserRoleMapping
 *
 * @property Role Role
 * @property User User
 */
class UserRoleMapping extends AppModel {

    public $belongsTo = array(
        'User', 'School', 'Department', 'Role'
    );

	public $actsAs = array(
		'OrganizationOwned'
	);

	/**
	 * Get a list of the users with a specific role on a department
	 *
	 * @param $alias string Alias of the role to get users for
	 * @param $department int ID of the department
	 * @return array
	 */
	public function listUsersWithRole($alias, $department) {
		return $this->find('list', array(
			'conditions' => array(
				$this->alias . '.role_id' => $this->Role->getRoleId($alias),
			),
			'recursive'  => 2,
			'fields' => array(
				$this->User->alias . '.' . $this->User->primaryKey,
				$this->User->alias . '.' . $this->User->displayField
			),
			'scopes'     => array('department'),
			'department' => $department
		));
	}
    
}
