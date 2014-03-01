<?php

class Permission extends AppModel {
	
    public $displayField = 'title';
        
    public function getPermissionsByAlias(array $aliases) {
        return $this->find('all', array(
            'conditions' => array(
                'system_alias' => $aliases
            )
        ));
    }
        
}
