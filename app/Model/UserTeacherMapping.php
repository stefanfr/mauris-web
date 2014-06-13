<?php

/**
 * Class UserTeacherMapping
 *
 * @property Teacher Teacher
 * @property User User
 */
class UserTeacherMapping extends AppModel {

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		),
		'Teacher' => array(
			'className' => 'Teacher',
			'foreignKey' => 'teacher_id'
		)
	);

	/**
	 * Get a list of teachers on a department that have not been assigned to a user
	 *
	 * @param $department int ID of the department
	 * @return array
	 */
	public function listUnassignedTeachers($department) {
		// Get a list of all the teachers that have been assigned already
		$assignedTeachers = $this->find('list', array(
			'conditions' => array(
				$this->Teacher->alias . '.department_id' => $department
			),
			'fields'     => array(
				$this->Teacher->alias . '.' . $this->Teacher->primaryKey,
				$this->Teacher->alias . '.' . $this->Teacher->displayField,
			),
			'recursive'  => 0
		));

		return $this->Teacher->find('list', array(
			'conditions' => array(
				'NOT' => array(
					$this->Teacher->alias . '.id' => array_keys($assignedTeachers)
				)
			),
			'recursive'  => -1,
			'department' => $department,
			'scopes'     => array('department')
		));
	}

}

