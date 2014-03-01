<?php

class UserRoleMapping extends AppModel {
        
    public $belongsTo = array(
        'User', 'School', 'Department', 'Role'
    );
    
}
