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
			'Transaction.user_balance_id' => $this->Auth->user('id')
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
		$user_balances = $this->Transaction->UserBalance->find('list', array(
			'fields' => array(
				'UserBalance.user_id',
				'User.username'
			),
			'recursive' => 2
		));
		$cards = $this->Transaction->UsedCard->find('list');

		$this->set(compact('user_balances', 'cards'));

		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Transaction']['created'] = $this->Transaction->getDataSource()->expression('NOW()');

			$this->Transaction->UserBalance->id = $this->request->data['Transaction']['user_balance_id'];
			$UserBalance = $this->Transaction->UserBalance->read();

			if (($UserBalance['UserBalance']['balance'] + $this->request->data['Transaction']['amount']) < 0) {
				throw new GoneException();
			}

			$this->Transaction->UserBalance->applyTransaction($this->request->data);

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