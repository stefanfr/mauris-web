<?php

App::uses('ScheduleEntry', 'Model');

class Classroom extends AppModel {
	
	public $displayField = 'code';
        
	public $hasOne = array(
		'MappingInformation' => array(
			'className' => 'ClassroomDetailsMapping',
			'foreignKey' => 'classroom_id'
		),
	);
        
        public $belongsTo = array(
            'GivenAtDeparment' => array(
                'className' => 'Department',
                'foreignKey' => 'department_id'
            )
        );
        
    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        
        $this->ScheduleEntry = new ScheduleEntry();
    }
        
    public function getAvailableClassrooms($timestamp, $departmentId) {
        $db = $this->getDataSource();
        
        $conditions = array();
        
        $usedClassroomsQuery = $db->buildStatement(array(
                'fields'     => array('DISTINCT ScheduleEntry.classroom_id'),
                'table'      => $db->fullTableName($this->ScheduleEntry),
                'alias'      => 'ScheduleEntry',
                'limit'      => null,
                'offset'     => null,
                'joins'      => array(
                    array(
                        'table' => 'periods',
                        'alias' => 'Period',
                        'type'  => 'left',
                        'conditions' => 'Period.id = ScheduleEntry.period'
                    )
                ),
                'conditions' => array(
                    '? BETWEEN CONCAT(ScheduleEntry.date, \' \', Period.start) AND CONCAT(ScheduleEntry.date, \' \', Period.end)' => date('Y-m-d H:i:s', $timestamp),
                    'ScheduleEntry.department_id' => $departmentId,
                    'ScheduleEntry.cancelled' => 0,
                    'ScheduleEntry.classroom_id = Classroom.id',
                ),
                'order'      => null,
                'group'      => null
            ),
            $this->ScheduleEntry
        );
        $conditions[] = $db->expression('NOT EXISTS(' . $usedClassroomsQuery . ')');
        $conditions['Classroom.department_id'] = $departmentId; 
        
        $recursive = 2;
        
        return $this->find('all', compact('conditions', 'recursive'));
    }

}
