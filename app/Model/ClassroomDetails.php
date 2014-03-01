<?php
class ClassroomDetails extends AppModel {

    public $useTable = 'classroom_details';

    public $hasMany = array(
        'MappingInformation' => array(
            'className' => 'ClassroomDetailsMapping',
            'foreignKey' => 'classroom_details_id'
        )
    );

    public function getByIds(array $ids) {
        return $this->_getByIds('classroom', 'ClassroomDetails', $ids);
    }
    
}

