<?php

class TimeAwareComponent extends Component {
    
    private $start;
    private $end;
    
    public function startup(\Controller $controller) {
        $year = date('o');
        $week = date('W');
        
        if (isset($controller->request->query['start'])) {
            if (ctype_digit($controller->request->query['start'])) {
                $this->start = (int) $controller->request->query['start'];
            } else {
                $this->start = strtotime($controller->request->query['start']);
            }
        } else {
            $this->start = strtotime("{$year}-W{$week}-1");
        }
        if (isset($controller->request->query['end'])) {
            if (ctype_digit($controller->request->query['end'])) {
                $this->end = (int) $controller->request->query['end'];
            } else {
                $this->end = strtotime($controller->request->query['end']);
            }
        } else {
            if ((!isset($this->settings['end'])) || ($this->settings['end'])) {
                $this->end = strtotime("{$year}-W{$week}-7");
            }
        }
    }
    
    public function getStart() {
        return $this->start;
    }
    
    public function hasEnd() {
        return (bool) $this->end;
    }


    public function getEnd() {
        return $this->end;
    }
    
}