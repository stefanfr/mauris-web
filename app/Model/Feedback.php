<?php

class Feedback extends AppModel {

	public $validate = array(
		'school_id'     => array(
			'rule' => array('decimal'),
		),
		'department_id' => array(
			'rule' => array('decimal'),
		),
		'body'          => array(
			'rule' => 'notEmpty'
		),
	);

	public $belongsTo = array(
		'ByUser' => array(
			'className'  => 'User',
			'foreignKey' => 'user_id'
		),
		'OnSchool' => array(
			'className'  => 'School',
			'foreignKey' => 'school_id'
		),
		'OnDepartment' => array(
			'className'  => 'Department',
			'foreignKey' => 'department_id'
		),
	);

	/**
	 * Add feedback
	 *
	 * @param $data array Data send with the form
	 * @param $user array Data of user sending the feedback
	 * @param $organizationId int ID of the organization the feedback was added on
	 * @param $departmentId int ID of the department the feedback was added on
	 * @return mixed The save method's return value
	 */
	public function addFeedback($data, $user, $organizationId, $departmentId) {
		if ($user) {
			$data[$this->alias]['user_id'] = $user['id'];
		}

		$data[$this->alias]['school_id'] = $organizationId;
		$data[$this->alias]['department_id'] = $departmentId;
		$data[$this->alias]['created'] = date('Y-m-d H:i:s');

		$this->create();
		$success = $this->save($data);
		if ($success) {
			$email = new CakeEmail();
			$email->emailFormat('both');
			$email->from(array('website@ictcollege.eu' => 'Feedback ICTCollege'));
			$email->to('m.cremers@cvo-technologies.com');
			$email->subject('Feedback');
			$email->template('feedback_submitted');
			$email->viewVars(
				array(
					'data'            => $data,
					'id'              => $this->getLastInsertID(),
					'user'            => $user,
					'school_name'     => $this->OnSchool->field('name', array(
						$this->OnSchool->alias . '.id' => $organizationId
					)),
					'department_name' => $this->OnDepartment->field('name', array(
						$this->OnDepartment->alias . '.id' => $this->OnDepartment->field('name')
					))
				)
			);
			$email->send();
		}

		return $success;
	}

}
