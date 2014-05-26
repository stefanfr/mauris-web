<?php

App::uses('AppController', 'Controller');

/**
 * Class TransactionsController
 *
 * @property Transaction Transaction
 */
class TransactionsController extends AppController {

	public $components = array(
		'AutoPermission',
		'Paginator' => array(
			'recursive' => 2
		)
	);

	public function index() {
		$transactions = $this->Paginator->paginate('Transaction', array(
			'Transaction.credit_account_id' => $this->Auth->user('id')
		));

		if (!empty($this->request->params['requested'])) {
			return $transactions;
		}
	}

	public function admin_stats() {
		$stats = array(
			'amount' => $this->Transaction->find('count')
		);

		if (!empty($this->request->params['requested'])) {
			return $stats;
		}
	}

	public function admin_index() {
		$transactions = $this->Paginator->paginate('Transaction');

		$this->set(compact('transactions'));
	}

	public function admin_add() {
		$credit_accounts = $this->Transaction->CreditAccount->find('list', array(
			'fields' => array(
				'CreditAccount.user_id',
				'User.username'
			),
			'recursive' => 2
		));
		$cards = $this->Transaction->UsedCard->find('list');

		$this->set(compact('credit_accounts', 'cards'));

		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Transaction']['created'] = $this->Transaction->getDataSource()->expression('NOW()');

			$this->Transaction->CreditAccount->id = $this->request->data['Transaction']['credit_account_id'];
			$creditAccount = $this->Transaction->CreditAccount->read();

			if (($creditAccount['CreditAccount']['credit'] + $this->request->data['Transaction']['amount']) < 0) {
				throw new GoneException();
			}

			$this->Transaction->CreditAccount->applyTransaction($this->request->data);

			$this->Transaction->create();
			if ($this->Transaction->save($this->request->data)) {

				$this->Session->setFlash(__('The transaction has been added'), 'alert', array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-success'
				));

				$this->redirect(array('action' => 'index'));

				return;
			}

			$this->Session->setFlash(__('Could not add the transaction'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-danger'
			));
		}
	}

	public function admin_delete($id) {
		$this->Transaction->id = $id;

		$transaction = $this->Transaction->read();
		if (!$transaction) {
			throw new NotFoundException();
		}

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Transaction->delete()) {

				$this->Session->setFlash(__('The transaction has been removed'), 'alert', array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-success'
				));

				$this->redirect(array('action' => 'index'));

				return;
			}

			$this->Session->setFlash(__('Could not remove the transaction'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-danger'
			));
		}
	}

}

class GoneException extends HttpException {

	/**
	 * Constructor
	 *
	 * @param string $message If no message is given 'Gone' will be the message
	 * @param integer $code Status code, defaults to 410
	 */
	public function __construct($message = null, $code = 410) {
		if (empty($message)) {
			$message = 'Gone';
		}
		parent::__construct($message, $code);
	}

}