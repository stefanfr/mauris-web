<?php

App::uses('AppController', 'Controller');

class HomeController extends AppController {

	public function manage_index() {

	}

	public function install_index() {

	}

	public function install_check() {
		$sources = array();

		$this->set(compact('sources'));
	}

}