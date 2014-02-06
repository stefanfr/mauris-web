<?php
class Classroom extends AppModel {
	
	public $displayField = 'code';
	
	public $hasMany = array(
		'ClassroomDetailsMapping' => array(
			'className' => 'ClassroomDetailsMapping',
			'foreignKey' => 'classroom_id'
		),
		/*'ScheduleEntry' => array(
			'className' => 'ScheduleEntry',
			'foreignKey' => 'classroom_id'
		)*/
	);

}
