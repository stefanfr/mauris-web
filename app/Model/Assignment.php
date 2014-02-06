<?php
class Assignment extends AppModel {
	
	public $useTable = 'assignments';
	
	public $displayField = 'title';
	
	public $belongsTo = array(
		'MappingBelongingTo' => array(
			'className' => 'AssignmentScheduleMapping',
			'foreignKey' => 'assignment_id'
		)
	);

}
