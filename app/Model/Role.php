<?php

class Role extends AppModel {
	
    public $displayField = 'title';

    public $hasMany = array(
        'UserRoleMapping', 'PermissionRoleMapping'
    );
        
}
