<?php

class School extends AppModel {

	public $displayField = 'name';
        
        public $hasMany = array(
            'HasDepartments' => array(
                'className' => 'Department',
                'foreignKey' => 'id'
            )
	);
	
}
