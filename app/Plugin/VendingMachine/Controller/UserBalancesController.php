<?php

App::uses('AppController', 'Controller');

/**
 * Class UserBalancesController
 *
 * @property UserBalance UserBalance
 */
class UserBalancesController extends AppController {

	public $components = array(
		'AutoPermission', 'Paginator', 'RequestHandler'
	);

	public function balance() {
		$this->UserBalance->id = $this->Auth->user('id');
		$balance = $this->UserBalance->field('UserBalance.balance');

		if (!empty($this->request->params['requested'])) {
			return $balance;
		}

		$this->set(compact('balance'));
	}

	public function admin_index() {
		$user_balances = $this->Paginator->paginate('UserBalance');

		$this->set(compact('user_balances'));
	}

	public function admin_view($id) {
		$this->UserBalance->id = $id;

		$user_balance = $this->UserBalance->read();
		if (!$user_balance) {
			throw new NotFoundException();
		}

		$this->set(compact('user_balance'));
	}

	public function admin_add() {
		$users = $this->UserBalance->User->find('list');

		$this->set(compact('users'));

		if ($this->request->is(array('post', 'put'))) {
			$this->UserBalance->create();
			if ($this->UserBalance->save($this->request->data)) {

				$this->Session->setFlash(__('The balance account has been added'), 'alert', array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-success'
				));

				return $this->redirect(array('action' => 'index'));
			}

			$this->Session->setFlash(__('Could not add the balance account'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-danger'
			));
		}
	}

	public function admin_edit($id) {
		$this->UserBalance->id = $id;

		$user_balance = $this->UserBalance->read();
		if (!$user_balance) {
			throw new NotFoundException();
		}

		$this->set(compact('user_balance'));

		if ($this->request->is(array('post', 'put'))) {
			if ($this->UserBalance->save($this->request->data)) {

				$this->Session->setFlash(__('The balance account has been changed.'), 'alert', array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-success'
				));

				return $this->redirect(array('action' => 'index'));
			}

			$this->Session->setFlash(__('Could not change the balance account'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-danger'
			));
		}

		if (!$this->request->data) {
			$this->request->data = $user_balance;
		}
	}

}