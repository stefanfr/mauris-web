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
		$this->Paginator->settings['scopes'] = array('organization', 'department');
		$this->Paginator->settings['organization'] = $this->SchoolInformation->getSchoolId();
		$this->Paginator->settings['department'] = $this->SchoolInformation->getDepartmentId();

		$user_role_mappings = $this->Paginator->paginate(array(
			'FIND_IN_SET("department", Role.visibility)'
		));

		$this->set(compact('user_role_mappings'));
	}

	public function manage_add() {

	}

}