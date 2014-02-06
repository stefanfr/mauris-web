<?php
class AssignmentScheduleMapping extends AppModel {

	public $hasOne = array(
		'Assignment' => array(
			'className' => 'Assignment',
			'foreignKey' => 'id'
		),
		'ScheduleEntry' => array(
			'className' => 'ScheduleEntry',
			'foreignKey' => 'id'
		)
	);
}

