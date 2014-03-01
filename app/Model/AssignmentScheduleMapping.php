<?php
class AssignmentScheduleMapping extends AppModel {

	public $belongsTo = array(
		'Assignment' => array(
			'className' => 'Assignment',
			'foreignKey' => 'assignment_id'
		),
		'ScheduleEntry' => array(
			'className' => 'ScheduleEntry',
			'foreignKey' => 'schedule_entry_id'
		)
	);
}
