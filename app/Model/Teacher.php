<?php
class Teacher extends AppModel {
	
    public $displayField = 'name';

    public $order = "Teacher.name";

    public $hasMany = array(
        'UserMappings' => array(
            'className' => 'UserTeacherMapping',
            'foreignKey' => 'teacher_id'
        )
    );

    public $belongsTo = array(
        'TeachesAtDeparment' => array(
            'className' => 'Department',
            'foreignKey' => 'department_id'
        )
    );

    public function getAllTeachers($departmentId) {
        $rawClasses = $this->find('all', array(
            'conditions' => array(
                'department_id' => $departmentId
            )
        ));

        $classes = array();
        foreach ($rawClasses as $rawClass) {
            $classes[] = $rawClass['Teacher'];
        }

        return $classes;
    }

}
