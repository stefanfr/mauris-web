<?php

App::uses('AppModel', 'Model');

class Department extends AppModel {
	
    public $displayField = 'name';

    public $belongsTo = array(
        'BelongingToSchool' => array(
            'className' => 'School',
            'foreignKey' => 'school_id'
        ),
        'UsesStyle' => array(
            'className' => 'Style',
            'foreignKey' => 'style_id'
        ),
        'UsesLanguage' => array(
            'className' => 'Language',
            'foreignKey' => 'language_id'
        )
    );

    public function findByHostname($hostname) {
        $key = 'department-' . $hostname; 
        $department = Cache::read($key);
        if ($department !== false) {
            return $department;
        }
        
        $department = $this->find('first', array(
            'recursive' => 2,
            'conditions' => array(
                'hostname' => $hostname 
            )
        ));
        Cache::write($key, $department);
        
        return $department;
    }

}
