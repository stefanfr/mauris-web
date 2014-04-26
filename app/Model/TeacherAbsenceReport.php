<?php

App::uses('AppModel', 'Model');
App::uses('OrganizationManage', 'Lib');

class TeacherAbsenceReport extends AppModel {

    public $belongsTo = array(
        'AffectedTeacher' => array(
            'className' => 'Teacher',
            'foreignKey' => 'teacher_id'
        )
    );

	public $actsAs = array(
		'OrganizationOwned'
	);

    public function getAbsentTeachers(
		$startTimestamp, $endTimestamp, \OrganizationSelector $Selector
	) {
        $hash = md5(implode(
            '|',
            array(
                round($startTimestamp / 3600),
                round($endTimestamp / 3600),
                $Selector
            )
        ));
        $key = 'absent-teachers-' . $hash;
        
        Cache::set(array('duration' => '+1 hour'));
        $data = Cache::read($key, 'absent-teachers');
        if ($data !== false) {
            return $data;
        }
        
		$data = $this->find(
			'all',
			array(
				'recursive' => 2,
				'conditions' => array(
					'TeacherAbsenceReport.date BETWEEN ? and ?' => array(
						date('Y-m-d', $startTimestamp), date('Y-m-d', $endTimestamp)
					)
				),
				'match' => $Selector
			)
		);
        
        Cache::set(array('duration' => '+1 hour'));
        Cache::write($key, $data, 'absent-teachers');
        
        return $data;
    }
    
}