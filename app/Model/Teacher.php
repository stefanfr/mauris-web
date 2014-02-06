<?php
class Teacher extends AppModel {
	
	public $displayField = 'name';
	
	public $hasMany = array(
		'ProfileTeacherMapping' => array(
			'className' => 'ProfileTeacherMapping',
			'foreignKey' => 'teacher_id'
		),
		/*'ScheduleEntry' => array(
			'className' => 'ScheduleEntry',
			'foreignKey' => 'teacher_id'
		)*/
	);

}
