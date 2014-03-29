<?php

class NamingHelper extends Helper {

    public function title() {
        $parts = array();

        if (isset($this->_View->viewVars['department_name'])) {
            $parts[] = $this->_View->viewVars['department_name'];
        }
        if (isset($this->_View->viewVars['school_name'])) {
            $parts[] = $this->_View->viewVars['school_name'];
        }

        if (empty($parts)) {
            $parts[] = 'Mauris';
        }

        return implode(' - ', $parts);
    }

    public function brand() {
        $text = 'Mauris';

        if (isset($this->_View->viewVars['school_name'])) {
            $text = $this->_View->viewVars['school_name'];
        }
        if (isset($this->_View->viewVars['department_name'])) {
            $text = $this->_View->viewVars['department_name'];
        }

        return $text;
    }

    public function footer() {
        $text = 'Mauris';

        if (isset($this->_View->viewVars['school_name'])) {
            $text = $this->_View->viewVars['school_name'];
        }
        if (isset($this->_View->viewVars['department_name'])) {
            $text .= ' (' . $this->_View->viewVars['department_name'] . ')';
        }

        return $text;
    }

}