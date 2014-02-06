<?php
class SubjectDetails extends AppModel {
	
    public $useTable = 'subject_details';
    
    public $hasMany = array(
		'SubjectDetailsMapping' => array(
			'className' => 'SubjectDetailsMapping',
			'foreignKey' => 'subject_details_id'
		)
    );
    
}
