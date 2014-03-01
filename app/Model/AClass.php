<?php
class AClass extends AppModel {

    public $name = 'Class';
	public $displayField = 'name';
	public $useTable = 'classes';
        
        public $hasMany = array(
            'StudentProfiles' => array(
                'className' => 'UserClassMapping',
                'foreignKey' => 'user_id'
            )
	);
        
        public $belongsTo = array(
            'GivenAtDeparment' => array(
                'className' => 'Department',
                'foreignKey' => 'department_id'
            )
        );
        
        public function getAllClasses($departmentId) {
            $rawClasses = $this->find('all', array(
                'conditions' => array(
                    'department_id' => $departmentId
                )
            ));
            
            $classes = array();
            foreach ($rawClasses as $rawClass) {
                $classes[] = $rawClass['AClass'];
            }
            
            return $classes;
        }
	
}
