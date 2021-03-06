<?php

class PublicTransitController extends AppController {

    public $components = array(
        'RequestHandler', 'ThemeAware', 'TimeAware', 'SchoolInformation', 'LanguageAware',
        'DataFilter' => array(
            'custom' => array(
                'stop_area_code'
            )
        )
    );
    public $uses = array('OvInfo.StopAreaCode', 'OvInfo.Journey');

    public function index() {
        $this->layout = null;
        
        $passes = array();
        
        $data = $this->StopAreaCode->find(
            'all',
            array(
                'conditions' => array(
                    'id' => explode(',', $this->DataFilter->getCustomFilter('stop_area_code'))
                ),
                'recursive' => 0
            )
        );
        
        $journeyCodes = array();
        
        foreach ($data['StopAreaCode'] as $stopAreaCode => $timingPoints) {
            $passes[$stopAreaCode] = array();
            
            unset($timingPoints['ServerTime']);
            foreach ($timingPoints as $timingPoint => $timingPointData) {
                $journeyCodes = array_merge($journeyCodes, array_keys($timingPointData['Passes']));
            }
        }
        
        $journeys = $this->Journey->find(
            'all',
            array(
                'conditions' => array(
                    'id' => $journeyCodes
                ),
                'recursive' => 0
            )
        );
        
        if ($journeys['Journey']) {
            foreach ($journeys['Journey'] as $journeyCode => $journey) {
                foreach ($journey['Stops'] as $stop) {
                    if (isset($passes[$stop['StopAreaCode']])) {
                        $passes[$stop['StopAreaCode']]['StopData']['TimingPointName'] = $stop['TimingPointName'];
                        $passes[$stop['StopAreaCode']]['Journeys'][$journeyCode]['JourneyData'] = $stop;
                    }
                    
                    $departureTime = new DateTime($stop['ExpectedDepartureTime'], new DateTimeZone('Europe/Amsterdam'));
                    
                    if (time() > $departureTime->getTimestamp()) {
                        unset($passes[$stop['StopAreaCode']]['Journeys'][$journeyCode]);
                    }
                }
            }
        }
        
        foreach ($passes as $stopAreaCode => $data) {
            uasort($passes[$stopAreaCode]['Journeys'], function ($a, $b) {
                $aTime = strtotime($a['JourneyData']['TargetArrivalTime']); 
                $bTime = strtotime($b['JourneyData']['TargetArrivalTime']); 

                 if ($aTime == $bTime) {
                     return 0;
                 }
                 return ($aTime < $bTime) ? -1 : 1;
             });
        }
        
        $this->set(array(
            'passes' => $passes,
            '_serialize' => array('passes')
        ));
    }
    
}
