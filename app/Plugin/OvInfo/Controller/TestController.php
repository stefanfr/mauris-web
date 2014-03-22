<?php

class TestController extends Controller {
    
    public $uses = array('OvInfo.StopAreaCode', 'OvInfo.Journey', 'OvInfo.Line', 'OvInfo.TimingPointCode');
    
    public function index() {
        /*$this->StopAreaCode->find(
            'first',
            array(
                'conditions' => array(
                    'bla' => 'bla'
                )
            )
        );
        
        $this->StopAreaCode->id = 'hmonoo';
        debug($this->StopAreaCode->read());*/
        
        debug($this->StopAreaCode->find(
            'all',
            array(
                'conditions' => array(
                    'TimingPointName' => ':/Helmond/i'
                ),
                'recursive' => 0
            )
        ));
        
        /*debug($this->Journey->find(
            'all',
            array(
                'recursive' => 2,
                'conditions' => array(
                    'id' => array('CXX_822206_L024_56_0')
                )
            )
        ));*/
        
        /*debug($this->Line->find(
            'all',
            array(
                'recursive' => 2,
                'conditions' => array(
                    'id' => array('VTN_1169_2')
                )
            )
        ));*/
        
        /*debug($this->TimingPointCode->find(
            'all',
            array(
                'recursive' => 1,
                'conditions' => array(
                    'id' => array('57330620')
                )
            )
        ));*/
    }
    
}