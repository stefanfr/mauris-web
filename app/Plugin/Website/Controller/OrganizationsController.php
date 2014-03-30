<?php

class OrganizationsController extends WebsiteAppController {

    public $uses = array('School');

    public $components = array(
        'Paginator' => array(
            'settings' => array(
                'limit' => 5,
                'order' => array(
                    'School.name ASC',
                )
            )
        )
    );

    public function index() {
        $organizations = $this->Paginator->paginate('School');

        $this->set('organizations', $organizations);
    }

}