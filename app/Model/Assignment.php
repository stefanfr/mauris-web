<?php
class Assignment extends AppModel {
	
	public $useTable = 'assignments';
	
	public $displayField = 'title';

	public $validate = array(
		'title' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'A title is required'
			)
		),
		'description' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'A description is required'
			)
		),
	);

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

	public function saveAssignment($data, $department) {
		$data[$this->alias]['department_id'] = $department;

		return $this->save($data);
	}

}
