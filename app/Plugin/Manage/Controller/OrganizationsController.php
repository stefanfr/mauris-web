<?php

App::uses('CakeEmail', 'Network/Email');

class OrganizationsController extends ManageAppController {

	public $components = array(
		'Paginator' => array(
			'settings' => array(
				'limit' => 5,
			)
		),
		'Security'
	);
	public $uses = array('School');

	public function beforeFilter() {
		parent::beforeFilter();

		$this->PermissionCheck->settings['global_lookup'][] = 'organization';
	}

	public function index() {
		if ($this->SchoolInformation->isSchoolIdAvailable()) {
			$this->redirect(array('action' => 'edit', $this->SchoolInformation->getSchoolId()));
		}

		debug($this->PermissionCheck->getScopes('organization', 'read'));

		$this->set('organizations', $this->Paginator->paginate('School'));
	}

	public function edit($id) {
		$this->School->id = $id;

		// If no organization data has been found return a 404
		if (!$organization = $this->School->read()) {
			throw new NotFoundException(__('That school doesn\'t exist'));
		}

		if ($organization['School']['id'] == $this->SchoolInformation->getSchoolId()) {
			$scope = 'school';
		} else {
			$scope = 'system';
		}

		// Check whenever the current logged in entity has the update
		// permission to organizations.
		if (!$this->PermissionCheck->checkPermission('organization', 'update', $scope)) {
			// Throw a 403 because the user doesn't have the appropriate
			// permissions
			throw new ForbiddenException();
		}
		
		$this->set('hostname_editable', $this->PermissionCheck->checkPermission('hostname', 'update', $scope));
		
		// If no data has been entered in the form, pre-populate it with the
		// data in the database
		if (!$this->request->data) {
			$this->request->data = $organization;
		}

		$conditions = array();
		$conditions['or']['UsesStyle.school_id'][] = $this->SchoolInformation->getSchoolId();
		$conditions['or'][] = 'UsesStyle.school_id IS NULL';
		
		$styles = $this->School->UsesStyle->find(
			'list', array(
				'fields'     => array('id', 'title', 'UsedBySchool.name'),
				'recursive'  => 2,
				'conditions' => $conditions,
			)
		);
		
		$languages = $this->School->UsesLanguage->find('list');

		if ($this->request->is(array('post', 'put'))) {
			if ($this->School->save($this->request->data)) {
				Cache::clearGroup('organization');

				$this->Session->setFlash(__('The organization has been changed.'), 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-success'
				));

				if ($this->Auth->user('system_email') != '') {
					$email = new CakeEmail();
					//$email->config('debug');
					$email->config('default');
					$email->emailFormat('both');
					$email->addTo($this->Auth->user('system_email'));
					$email->template('Manage.organization_change');
					$email->viewVars(array_merge(
						array(
							'original' => $organization,
							'current'  => $this->request->data,
							'styles'   => call_user_func_array('array_replace', $styles)
						), 
						compact('organization', 'languages')
					));
					$response = $email->send();
				}
				
				return $this->redirect(array('action' => 'index'));
			}

			$this->Session->setFlash(__('Could not change the organization'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-danger'
			));
		}
		$this->set(compact('organization', 'styles', 'languages'));
	}

}