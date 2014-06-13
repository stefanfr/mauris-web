<?php

App::uses('AppController', 'Controller');

/**
 * Class UserTeacherMappingsController
 *
 * @property UserTeacherMapping UserTeacherMapping
 * @property UserRoleMapping UserRoleMapping
 */
class UserTeacherMappingsController extends AppController {

	public $components = array(
		'Paginator', 'AutoPermission'
	);

	public function manage_index() {
		$user_teacher_mappings = $this->Paginator->paginate('UserTeacherMapping', array(
			'Teacher.department_id' => $this->SchoolInformation->getDepartmentId()
		));

		$this->set(compact('user_teacher_mappings'));
	}

	public function manage_add() {
		$this->loadModel('UserRoleMapping');

		$teachers = $this->UserTeacherMapping->listUnassignedTeachers(
			$this->SchoolInformation->getDepartmentId()
		);
		$users = $this->UserTeacherMapping->User->find('list');

		$this->set(compact('teachers', 'users'));

		if ($this->request->is('post')) {
			$this->UserTeacherMapping->create();
			if ($this->UserTeacherMapping->save($this->request->data)) {
				$this->Session->setFlash(__('The teacher assignment has been created'), 'alert', array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-success'
				));

				// Check if the user has the teacher role already
				if (!$this->UserRoleMapping->userHasRole(
					$this->request->data['UserTeacherMapping']['user_id'], 'teacher',
					$this->SchoolInformation->getSchoolId(), $this->SchoolInformation->getDepartmentId()
				)) {
					// If not give the user the teacher role
					$this->UserRoleMapping->assignRoleToUser(
						$this->request->data['UserTeacherMapping']['user_id'], 'teacher',
						$this->SchoolInformation->getSchoolId(), $this->SchoolInformation->getDepartmentId()
					);
				}

				$this->redirect(array('action' => 'index'));
			}

			$this->Session->setFlash(__('Could not create teacher assignment'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-danger'
			));
		}
	}

	public function manage_delete($id) {
		$user_role_mapping = $this->UserTeacherMapping->read(null, $id);
		if (empty($user_role_mapping)) {
			throw new NotFoundException();
		}

		if ($this->UserTeacherMapping->delete($id)) {
			$this->Session->setFlash(__('The teacher assignment has been removed'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-success'
			));

			$this->redirect(array('action' => 'index'));
		}

		$this->Session->setFlash(__('Could not remove the teacher assignment'), 'alert', array(
			'plugin' => 'BoostCake',
			'class'  => 'alert-danger'
		));
	}

}