<?php
class Teacher extends AppModel {
	
    public $useTable = 'teachers';
    
    public $hasMany = array(
		'ScheduleEntry' => array(
			'className' => 'ScheduleEntry',
			'foreignKey' => 'teacher_id'
		)
	);
    
}
