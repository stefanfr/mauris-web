<?php

class StopAreaCode extends AppModel {
    
    public $useDbConfig = 'ovInfo';
    
    public $useTable = 'stopareacode';
    
    public $belongsTo = array(
        'TimingPoint' => array(
            'className' => 'OvInfo.TimingPointCode',
            'foreignKey' => 'TimingPointCode'
        )
    );
    
}