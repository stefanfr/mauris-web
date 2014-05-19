<?php

App::uses('AppController', 'Controller');

class HomeController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow(array(
			'website_index'
		));
	}


	public function website_index() {

	}

	public function manage_index() {

	}

	public function admin_index() {

	}

	public function install_index() {

	}

	public function install_check() {
		$sources = array(
			array(
				'title' => __('Roles'),
				'url'   => Router::url(array(
						'controller' => 'roles',
						'action'     => 'check',
						'ext'        => 'json',
						'install'    => true
					))
			),
			array(
				'title' => __('Permissions'),
				'url'   => Router::url(array(
						'controller' => 'permissions',
						'action'     => 'check',
						'ext'        => 'json',
						'install'    => true
					))
			)
		);

		$this->set(compact('sources'));
	}

}