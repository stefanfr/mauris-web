<?php

class Journey extends AppModel {
    
    public $useDbConfig = 'ovInfo';
    
    public $useTable = 'journey';
    
    public $belongsTo = array(
        'Stop' => array(
            'className' => 'OvInfo.StopAreaCode',
            'foreignKey' => 'StopAreaCode',
            'container' => 'Stops'
        )
    );
    
}