<?php
class SubjectDetailsMapping extends AppModel {
	
	public $useTable = 'subject_details_mappings';
	
	public $belongsTo = array(
		'Subject' => array(
			'className' => 'Subject',
			'foreignKey' => 'subject_id'
		),
		'SubjectDetails' => array(
			'className' => 'SubjectDetails',
			'foreignKey' => 'subject_details_id'
		)
	);
}
