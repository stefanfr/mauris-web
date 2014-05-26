<?php

App::uses('AppController', 'Controller');

/**
 * Class CardsController
 *
 * @property Card Card
 */
class CardsController extends AppController {

	public $components = array(
		'AutoPermission',
		'Paginator' => array(
			'recursive' => 2
		)
	);

	public function admin_index() {
		$cards = $this->Paginator->paginate('Card');

		$this->set(compact('cards'));
	}

	public function admin_add() {
		$credit_accounts = $this->Card->CreditAccount->find('list', array(
			'fields' => array(
				'CreditAccount.user_id',
				'User.username'
			),
			'recursive' => 2
		));

		$this->set(compact('credit_accounts'));

		if ($this->request->is(array('post', 'put'))) {
			$this->Card->create();
			if ($this->Card->save($this->request->data)) {

				$this->Session->setFlash(__('The card has been added'), 'alert', array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-success'
				));

				return $this->redirect(array('action' => 'index'));
			}

			$this->Session->setFlash(__('Could not add the card'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-danger'
			));
		}
	}

	public function admin_edit($id) {
		$this->Card->id = $id;

		$card = $this->Card->read();
		if (!$card) {
			throw new NotFoundException();
		}

		$credit_accounts = $this->Card->CreditAccount->find('list', array(
			'fields' => array(
				'CreditAccount.user_id',
				'User.username'
			),
			'recursive' => 2
		));

		$this->set(compact('card', 'credit_accounts'));

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Card->save($this->request->data)) {

				$this->Session->setFlash(__('The card has been changed'), 'alert', array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-success'
				));

				return $this->redirect(array('action' => 'index'));
			}

			$this->Session->setFlash(__('Could not change the card'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-danger'
			));
		}

		if (!$this->request->data) {
			$this->request->data = $card;
		}
	}

}