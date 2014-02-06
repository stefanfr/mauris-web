<?php
class AClass extends AppModel {
	
    public $useTable = 'classes';
    
    public $hasMany = array(
		'ScheduleEntry' => array(
			'className' => 'ScheduleEntry',
			'foreignKey' => 'class_id'
		)
	);
    
}
