<?php
class Assignment extends AppModel {
	
	public $useTable = 'assignments';
	
	public $displayField = 'title';
	
	public $hasMany = array(
		'MappingBelongingTo' => array(
			'className' => 'AssignmentScheduleMapping',
			'foreignKey' => 'assignment_id'
		)
	);
        
        public $belongsTo = array(
            'GivenAtDeparment' => array(
                'className' => 'Department',
                'foreignKey' => 'department_id'
            )
        );

}
