<?php

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

}