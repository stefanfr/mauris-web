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

	/**
	 * Assign a role to a user
	 *
	 * @param $userId int ID of the user
	 * @param $role string Role to assign
	 * @param $organization int ID of the organization to assign it on
	 * @param $department int ID of the department to assign it on
	 * @return bool True if the role was successfully assigned to the user
	 */
	public function assignRoleToUser($userId, $role, $organization = null, $department = null) {
		$this->create();

		return $this->save(array(
			$this->alias => array(
				'user_id'       => $userId,
				'school_id'     => $organization,
				'department_id' => $department,
				'role_id'       => $this->Role->getRoleId($role)
			)
		));
	}

	/**
	 * Checks if the user has a role
	 *
	 * @param $userId int ID of the user to check it on
	 * @param $role string The role to check for
	 * @param int $organization ID of the organization to check on
	 * @param int $department ID of the department to check on
	 * @return bool True if the user has the role
	 */
	public function userHasRole($userId, $role, $organization = null, $department = null) {
		return $this->find('count', array(
			'conditions' => array(
				$this->alias . '.user_id'       => $userId,
				$this->alias . '.school_id'     => $organization,
				$this->alias . '.department_id' => $department,
				$this->alias . '.role_id'       => $this->Role->getRoleId($role)
			)
		)) != 0;
	}

}
