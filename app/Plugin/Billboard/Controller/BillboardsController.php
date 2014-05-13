<?php

App::uses('AppController', 'Controller');

/**
 * Class BillboardsController
 *
 * @property Billboard Billboard
 * @property SchoolInformationComponent SchoolInformation
 */
class BillboardsController extends AppController {

	public $components = array(
		'Paginator'
	);

	public $paginate = array(
		'limit' => 5
	);

	public function manage_index() {
		$allowedScopes = $this->PermissionCheck->getScopes('billboard', 'read');

		if (empty($allowedScopes)) {
			throw new ForbiddenException();
		}
		$this->Paginator->settings = $this->paginate;

		$conditions = array();
		if (in_array('system', $allowedScopes)) {
			$conditions['and']['or'][] = array(
				'and' => array(
					'Billboard.organization_id IS NULL',
					'Billboard.organization_id IS NULL'
				)
			);
		}
		if (in_array('school', $allowedScopes)) {
			$conditions['and']['or'][] = array(
				'and' => array(
					'Billboard.organization_id' => $this->SchoolInformation->getSchoolId(),
					'Billboard.department_id IS NULL'
				)
			);
		}
		if ((in_array('department', $allowedScopes)) && ($this->SchoolInformation->isDepartmentIdAvailable())) {
			$conditions['and']['or'][] = array(
				'and' => array(
					'Billboard.organization_id' => $this->SchoolInformation->getSchoolId(),
					'Billboard.department_id' => $this->SchoolInformation->getDepartmentId()
				)
			);
		}

		$this->set(
			'billboards',
			$this->Paginator->paginate(
				'Billboard', $conditions
			)
		);
	}

}