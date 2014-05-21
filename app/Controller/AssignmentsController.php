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
		'AutoPermission'
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

	public function manage_edit($id) {

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

}