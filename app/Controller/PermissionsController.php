<?php

App::uses('AppController', 'Controller');

/**
 * Class PermissionsController
 *
 * @property Permission Permission
 * @property InstallComponent Install
 */
class PermissionsController extends AppController {

	public $installData = array(
		array(
			'Permission' => array(
				'system_alias' => 'post',
				'title'        => 'Post'
			)
		),
		array(
			'Permission' => array(
				'system_alias' => 'billboard',
				'title'        => 'Billboard'
			)
		),
		array(
			'Permission' => array(
				'system_alias' => 'admin',
				'title'        => 'Admin'
			)
		),
		array(
			'Permission' => array(
				'system_alias' => 'style',
				'title'        => 'Style'
			)
		),
		array(
			'Permission' => array(
				'system_alias' => 'event',
				'title'        => 'Event'
			)
		),
		array(
			'Permission' => array(
				'system_alias' => 'assignment',
				'title'        => 'Assignment'
			)
		),
		array(
			'Permission' => array(
				'system_alias' => 'teacher',
				'title'        => 'Teacher'
			)
		),
		array(
			'Permission' => array(
				'system_alias' => 'student',
				'title'        => 'Student'
			)
		),
		array(
			'Permission' => array(
				'system_alias' => 'user_role_mapping',
				'title'        => 'User assignment'
			)
		),
	);

	public $components = array(
		'RequestHandler', 'Install'
	);

	function beforeFilter() {
		parent::beforeFilter();

		$this->Install->settings = array(
			'data'   => $this->installData,
			'unique' => 'system_alias',
			'title'  => 'system_alias'
		);
	}


	public function install_check() {
		$this->Install->check();
	}

}