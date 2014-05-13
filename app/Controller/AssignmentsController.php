<?php

class AssignmentsController extends AppController {

	public $uses = array('Assignment');

	public $components = array('Paginator');

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

}