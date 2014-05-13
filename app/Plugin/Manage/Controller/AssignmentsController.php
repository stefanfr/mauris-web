<?php

/**
 * Class AssignmentsController
 *
 * @property Assignment Assignment
 */
class AssignmentsController extends ManageAppController {

    public $uses = array('Assignment');

    public $components = array('Paginator');

    public $paginate = array(
        'limit' => 5,
    );

    public function index() {
        $this->Paginator->settings = $this->paginate;

        $this->set(
            'assignments',
            $this->Paginator->paginate(
                'Assignment'
            )
        );
    }

	public function edit($id) {

	}

	/**
	 * @param $id The assignment id
	 * @throws NotFoundException When the given assignment doesn't exist
	 */
	public function view($id) {
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