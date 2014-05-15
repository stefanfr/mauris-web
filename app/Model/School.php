<?php

class School extends AppModel {

	public $displayField = 'name';

	public $validate = array(
		'name' => array(
			array(
				'rule'    => 'notEmpty',
				'message' => 'Enter a name for the organization'
			)
		),
		'logo' => array(
			array(
				'rule'       => 'url',
				'allowEmpty' => true
			)
		)
	);

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
