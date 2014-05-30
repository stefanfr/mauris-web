<?php

App::uses('AppModel', 'Model');

class TeacherAbsenceReport extends AppModel {
    
    public $belongsTo = array(
        'AffectedTeacher' => array(
            'className' => 'Teacher',
            'foreignKey' => 'teacher_id'
        )
    );
    
    public function getAbsentTeachers($startTimestamp, $endTimestamp, $departmentId) {
        $hash = md5(implode(
            '|',
            array(
                round($startTimestamp / 3600),
                round($endTimestamp / 3600),
                $departmentId
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
                    $this->alias . '.department_id' => $departmentId,
                    $this->alias . '.date BETWEEN ? and ?' => array(
                        date('Y-m-d', $startTimestamp), date('Y-m-d', $endTimestamp)
                    )
                )
            )
        );
        
        Cache::set(array('duration' => '+1 hour'));
        Cache::write($key, $data, 'absent-teachers');
        
        return $data;
    }
    
}