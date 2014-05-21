<?php

App::uses('AppModel', 'Model');

/**
 * Class Event
 *
 * @property School School
 * @property Department Department
 */
class Event extends AppModel {

	public $validate = array(
		'title' => array(
			'rule'     => 'notEmpty',
			'required' => true
		),
		'start' => array(
			'rule'     => 'notEmpty',
			'required' => true
		),
		'end'   => array(
			'rule'     => 'notEmpty',
			'required' => true
		)
	);

	public $belongsTo = array(
		'School'     => array(
			'className'  => 'School',
			'foreignKey' => 'school_id'
		),
		'Department' => array(
			'className'  => 'Department',
			'foreignKey' => 'department_id'
		)
	);

}