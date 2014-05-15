<?php

App::uses('AppController', 'Controller');

/**
 * Class RolesController
 *
 * @property Role Role
 * @property InstallComponent Install
 */
class RolesController extends AppController {

	public $roles = array(
		array(
			'Role' => array(
				'system_alias' => 'full_administrator',
				'title'        => 'Full administrator',
				'visibility'   => 'system,user'
			)
		),
		array(
			'Role' => array(
				'system_alias' => 'user',
				'title'        => 'User',
				'visibility'   => 'system'
			)
		),
		array(
			'Role' => array(
				'system_alias' => 'school_administrator',
				'title'        => 'School administrator',
				'visibility'   => 'system'
			)
		)
	);

	public $components = array(
		'RequestHandler', 'Install'
	);

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Install->settings = array(
			'data'   => $this->roles,
			'unique' => 'system_alias',
			'title'  => 'system_alias'
		);
	}

	public function install_load() {
		$roles = $this->roles;
		$existingRoles = array_flip($this->Role->find('list', array(
			'fields' => array('id', 'system_alias')
		)));

		foreach ($roles as &$role) {
			if (isset($existingRoles[$role['Role']['system_alias']])) {
				$role['Role']['id'] = $existingRoles[$role['Role']['system_alias']];
			}
		}

		$this->Role->saveAll($roles);
	}

	public function install_check() {
		$this->Install->check();
	}

}