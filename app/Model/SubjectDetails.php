<?php
class SubjectDetails extends AppModel {

        public $useTable = 'subject_details';
    
	public $hasMany = array(
		'MappingInformation' => array(
			'className' => 'SubjectDetailsMapping',
			'foreignKey' => 'subject_details_id'
		)
	);
        
        public function getByIds(array $ids) {
            return $this->_getByIds('subject', 'SubjectDetails', $ids);
        }
}

