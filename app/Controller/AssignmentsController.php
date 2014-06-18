<?php

/**
 * Class AssignmentsController
 *
 * @property Assignment Assignment
 */
class AssignmentsController extends AppController {

	public $uses = array('Assignment');

	public $components = array(
		'Paginator',
		'AutoPermission',
		'ModelFlash'
	);

	public $paginate = array(
		'limit' => 5,
	);

	public function manage_index() {
		$this->Paginator->settings = $this->paginate;

		$this->set(
			'assignments',
			$this->Paginator->paginate(
				'Assignment'
			)
		);
	}

	public function manage_add() {
		if ($this->request->is('post')) {
			$this->Assignment->create();
			if ($this->Assignment->saveAssignment($this->request->data, $this->SchoolInformation->getDepartmentId())) {

				$this->ModelFlash->success(__('The assignment has been changed added'));

				$this->redirect(array('action' =>  'index'));
			}

			$this->ModelFlash->succes(__('The could assignment not be added'));
		}
	}

	public function manage_edit($id) {
		$this->Assignment->id = $id;
		$assignment = $this->Assignment->read();
		if ($assignment === null) {
			throw new NotFoundException();
		}

		if (empty($this->request->data)) {
			$this->request->data = $assignment;
		}

		$this->set(compact('assignment'));

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Assignment->saveAssignment($this->request->data, $this->SchoolInformation->getDepartmentId())) {

				$this->ModelFlash->success(__('The assignment has been changed successfully'));

				$this->redirect(array('action' =>  'index'));
			}

			$this->ModelFlash->succes(__('The could assignment not be changed'));
		}
	}

	/**
	 * @param $id The assignment id
	 * @throws NotFoundException When the given assignment doesn't exist
	 */
	public function manage_view($id) {
		$this->Assignment->id = $id;
		$assignment = $this->Assignment->read();
		if ($assignment === null) {
			throw new NotFoundException();
		}

		$this->set(array(
			'assignment' => $assignment
		));
	}

	public function manage_delete($id) {
		$this->Assignment->id = $id;
		$assignment = $this->Assignment->read();
		if ($assignment === null) {
			throw new NotFoundException();
		}

		if ($this->Assignment->delete()) {

			$this->ModelFlash->danger(__('The assignment has been changed removed'));

			$this->redirect(array('action' =>  'index'));
		}

		$this->ModelFlash->danger(__('The could assignment not be removed'));
	}

}