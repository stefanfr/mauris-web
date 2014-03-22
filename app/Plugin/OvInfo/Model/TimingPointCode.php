<?php

class TimingPointCode extends AppModel {
    
    public $useDbConfig = 'ovInfo';
    
    public $useTable = 'tpc';
    
    public $belongsTo = array(
        'Journey' => array(
            'className' => 'OvInfo.Journey',
            'foreignKey' => 'index',
            'container' => 'Passes'
        )
    );
    
}