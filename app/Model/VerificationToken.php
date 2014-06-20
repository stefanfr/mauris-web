<?php

App::uses('AppModel', 'Model');
App::uses('CakeEmail', 'Network/Email');

/**
 * Class VerificationToken
 *
 * @property User User
 */
class VerificationToken extends AppModel {

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		)
	);

	public $validate = array(
		'type'     => array(
			'rule'     => array('inList', array('registration', 'delete')),
			'required' => true
		),
		'token'     => array(
			'rule' => array('uuid'),
			'required' => true
		)
	);

	public function createRegistrationToken($userId) {
		$user = $this->User->read(null, $userId);
		if (empty($user)) {
			return false;
		}

		$uuid = String::uuid();

		$this->create();
		$verification_token = $this->save(array(
			$this->alias => array(
				'user_id' => $userId,
				'type'    => 'registration',
				'token'   => $uuid
			)
		));

		if ($verification_token) {
			$email = new CakeEmail();
			//$email->config('debug');
			$email->emailFormat('html');
			$email->from(array('noreply@mauris.systems' => 'Mauris'));
			$email->to($user['User']['email']);
			$email->subject(__('Verify your account'));
			$email->template('user_verification');
			$email->viewVars(compact('verification_token'));
			$email->send();
		}

		return $verification_token;
	}

	public function checkRegistrationToken($token) {
		return (bool) $this->find('count', array(
			'conditions' => array(
				$this->alias . '.token' => $token,
				$this->alias . '.type' => 'registration'
			)
		));
	}

}