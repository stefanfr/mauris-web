<?php
class ScheduleEntry extends AppModel {
	
	public $belongsTo = array(
		'Class' => array(
			'className' => 'Class',
			'foreignKey' => 'class_id'
		),
		'Subject' => array(
			'className' => 'Subject',
			'foreignKey' => 'subject_id'
		),
		'Teacher' => array(
			'className' => 'Teacher',
			'foreignKey' => 'teacher_id'
		),
		'Classroom' => array(
			'className' => 'Classroom',
			'foreignKey' => 'classroom_id'
		)
	);
	
	public $hasMany = array(
		'AssignmentScheduleMapping' => array(
			'className' => 'AssignmentScheduleMapping',
			'foreignKey' => 'schedule_entry_id'
		)
	);

}
