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
        return $this->find(
            'all',
            array(
                'recursive' => 2,
                'conditions' => array(
                    'TeacherAbsenceReport.department_id' => $departmentId,
                    'TeacherAbsenceReport.date BETWEEN ? and ?' => array(
                        date('Y-m-d', $startTimestamp), date('Y-m-d', $endTimestamp)
                    )
                )
            )
        );
    }
    
}