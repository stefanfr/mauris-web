<?php

App::uses('AppController', 'Controller');

/**
 * Class UserRoleMappingsController
 *
 * @property UserRoleMapping UserRoleMapping
 */
class UserRoleMappingsController extends AppController {

	public $uses = array('UserRoleMapping');

	public $components = array('Paginator', 'AutoPermission');

	public function manage_index() {
		$user_role_mappings = $this->Paginator->paginate(array(
			'UserRoleMapping.department_id' => $this->SchoolInformation->getDepartmentId(),
			'FIND_IN_SET("department", Role.visibility)'
		));

		$this->set(compact('user_role_mappings'));
	}

	public function manage_add() {

	}

	protected function _getRoleId($systemAlias) {
		$role = $this->UserRoleMapping->Role->find('first', array(
			'conditions' => array('system_alias' => $systemAlias),
			'recursive' => -1
		));

		return $role['Role']['id'];
	}

}