<?php
class Subject extends AppModel {
	
    public $useTable = 'subjects';
    
    public $hasMany = array(
		'ScheduleEntry' => array(
			'className' => 'ScheduleEntry',
			'foreignKey' => 'subject_id'
		)
	);
	
	public $belongsTo = array(
		'subject_details_mapping' => array(
			'className' => 'SubjectDetailsMapping',
			'foreignKey' => 'subject_id'
		)
	);
    
}
