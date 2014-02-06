<?php
class ScheduleEntry extends AppModel {
	
    public $useTable = 'schedule_entries';
    
    public $belongsTo = array(
		'GivenByTeacher' => array(
			'className' => 'Teacher',
			'foreignKey' => 'teacher_id'
		),
		'GivenToClass' => array(
			'className' => 'AClass',
			'foreignKey' => 'class_id'
		),
		'GivenSubject' => array(
			'className' => 'Subject',
			'foreignKey' => 'subject_id'
		)
    );
    
}
