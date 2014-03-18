<?php

class DataFilterComponent extends Component {
    
    private $limit;
    
    private $custom = array();
    
    public function startup(\Controller $controller) {
        if (isset($controller->request->query['limit'])) {
            if (!$this->isSupported('limit')) {
                throw new BadRequestException('Unsupported filter: limit');   
            }
            
            $this->limit = (int) $controller->request->query['limit'];
        }
        foreach ($controller->request->query as $filter => $content) {
            if ($this->isSupported($filter)) {
                $this->custom[$filter] = $content;
            }
        }
    }
    
    public function hasLimit() {
        return $this->limit;
    }
    
    public function getLimit() {
        return $this->limit;
    }
    
    public function hasCustomFilter($filter) {
        return isset($this->custom[$filter]);
    }
    
    public function getCustomFilter($filter) {
        return $this->custom[$filter];
    }
    
    private function isSupported($filter) {
        $supported = false;
        if (isset($this->settings['supported'])) {
            if ($supportedFilter = in_array($filter, $this->settings['supported'])) {
                $supported = $supportedFilter;
            }
        }
        if (isset($this->settings['custom'])) {
            if ($supportedFilter = in_array($filter, $this->settings['custom'])) {
                $supported = $supportedFilter;
            }
        }
        
        return $supported;
    }
    
}