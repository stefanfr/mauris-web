<?php

class Style extends AppModel {

    public $displayField = 'title';

    public $recursive = 2;
    
    public $belongsTo = array(
        'UsedBySchool' => array(
            'className' => 'School',
            'foreignKey' => 'school_id'
        ),
        'UsesBaseStyle' => array(
            'className' => 'Style',
            'foreignKey' => 'base_style_id'
        )
    );

    public $hasMany = array(
        'UsedInStyles' => array(
            'className' => 'Style',
            'foreignKey' => 'base_style_id'
        )    
    );
    
    public function getStyle($id) {
        $style = array();
        while ($styleData = $this->getStyleById($id)) {
            foreach ($styleData['Style'] as $column => $value) {
                if ((!isset($style[$column])) && ($column)) {
                    $style[$column] = $value;
                }
            }
            
            $id = $styleData['UsesBaseStyle']['id'];
        }
        
        return $style;
    }
    
    public function getStyleById($id) {
        $key = 'style-' . $id; 
        $style = Cache::read($key);
        if ($style !== false) {
            return $style;
        }
        
        $style = $this->findById($id);
        Cache::write($key, $style);
        
        return $style;
    }
	
}
