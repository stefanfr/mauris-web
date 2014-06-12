<?php

App::uses('UserRoleMappingsController', 'Controller');

class StudentsController extends UserRoleMappingsController {

	public $components = array('Paginator', 'AutoPermission');

	public function manage_index() {
		$this->Paginator->settings['scopes'] = array('organization', 'department');
		$this->Paginator->settings['organization'] = $this->SchoolInformation->getSchoolId();
		$this->Paginator->settings['department'] = $this->SchoolInformation->getDepartmentId();

		$students = $this->Paginator->paginate('UserRoleMapping', $this->_buildConditions());

		$this->set(compact('students'));
	}

	public function manage_add() {
		$this->request->data['UserRoleMapping']['role_id'] = $this->_getRoleId('student');
		$this->request->data['UserRoleMapping']['department_id'] = $this->SchoolInformation->getDepartmentId();

		$users = $this->UserRoleMapping->User->find('list', array('conditions' => array('NOT' => array(
			'User.id' => array_keys($this->UserRoleMapping->find('list', array(
				'conditions' => $this->_buildConditions(),
				'fields' => array('User.id', 'User.id'),
				'recursive' => 2
			)))
		))));

		$this->set(compact('users'));

		if ($this->request->is(array('post'))) {
			$this->UserRoleMapping->create();
			if ($this->UserRoleMapping->save($this->request->data)) {
				$this->Session->setFlash(__('The student has been added'), 'alert', array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-success'
				));

				$this->redirect(array('action' => 'index'));
			}

			$this->Session->setFlash(__('Could not add the student'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-danger'
			));
		}
	}

	public function manage_delete($id) {
		if ($this->UserRoleMapping->delete($id)) {
			$this->Session->setFlash(__('The student has been deleted'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-success'
			));

			$this->redirect(array('action' => 'index'));
		}

		$this->Session->setFlash(__('Could not delete the student'), 'alert', array(
			'plugin' => 'BoostCake',
			'class'  => 'alert-danger'
		));
	}

	private function _buildConditions() {
		return array(
			'UserRoleMapping.role_id' => $this->_getRoleId('student'),
			'UserRoleMapping.department_id' => $this->SchoolInformation->getDepartmentId()
		);
	}

}