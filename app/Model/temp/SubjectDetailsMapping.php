<?php
class SubjectDetailsMapping extends AppModel {
	
    public $useTable = 'subject_details_mapping';
    
    public $hasAndBelongsToMany = array(
		'Subject', 'SubjectDetails'
	);

}
