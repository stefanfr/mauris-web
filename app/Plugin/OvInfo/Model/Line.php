<?php

class Line extends AppModel {
    
    public $useDbConfig = 'ovInfo';
    
    public $useTable = 'line';
    
    /*public $belongsTo = array(
        'Stop' => array(
            'className' => 'OvInfo.TimingPointCode',
            'foreignKey' => 'TimingPointCode',
            'container' => 'Network'
        )
    );*/
    
}