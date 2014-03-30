<?php

class School extends AppModel {

	public $displayField = 'name';
        
        public $hasMany = array(
            'HasDepartments' => array(
                'className' => 'Department',
                'foreignKey' => 'school_id'
            )
	);

    public $belongsTo = array(
        'UsesStyle' => array(
            'className' => 'Style',
            'foreignKey' => 'style_id'
        ),
        'UsesLanguage' => array(
            'className' => 'Language',
            'foreignKey' => 'language_id'
        )
    );
	
}
