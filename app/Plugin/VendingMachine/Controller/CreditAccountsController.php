<?php

App::uses('AppController', 'Controller');

/**
 * Class CreditAccountsController
 *
 * @property CreditAccount CreditAccount
 */
class CreditAccountsController extends AppController {

	public $components = array(
		'AutoPermission', 'Paginator', 'RequestHandler'
	);

	public function balance() {
		$this->CreditAccount->id = $this->Auth->user('id');
		$balance = $this->CreditAccount->field('CreditAccount.credit');

		if (!empty($this->request->params['requested'])) {
			return $balance;
		}

		$this->set(compact('balance'));
	}

	public function admin_index() {
		$credit_accounts = $this->Paginator->paginate('CreditAccount');

		$this->set(compact('credit_accounts'));
	}

	public function admin_add() {
		$users = $this->CreditAccount->User->find('list');

		$this->set(compact('users'));

		if ($this->request->is(array('post', 'put'))) {
			$this->CreditAccount->create();
			if ($this->CreditAccount->save($this->request->data)) {

				$this->Session->setFlash(__('The credit account has been added'), 'alert', array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-success'
				));

				return $this->redirect(array('action' => 'index'));
			}

			$this->Session->setFlash(__('Could not add the credit account'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-danger'
			));
		}
	}

	public function admin_edit($id) {
		$this->CreditAccount->id = $id;

		$credit_account = $this->CreditAccount->read();
		if (!$credit_account) {
			throw new NotFoundException();
		}

		$this->set(compact('credit_account'));

		if ($this->request->is(array('post', 'put'))) {
			if ($this->CreditAccount->save($this->request->data)) {

				$this->Session->setFlash(__('The credit account has been changed.'), 'alert', array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-success'
				));

				return $this->redirect(array('action' => 'index'));
			}

			$this->Session->setFlash(__('Could not change the credit account'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-danger'
			));
		}

		if (!$this->request->data) {
			$this->request->data = $credit_account;
		}
	}

}