<?php

class PermissionRoleMapping extends AppModel {
    
    public $belongsTo = array(
        'Permission', 'Role'
    );
    
    public function getPermissionsForCheck($role, $alias, $action, $scope = null, $schoolId = null, $departmentId = null) {
        $conditions = array(
            'role_id' => $role,
            'Permission.system_alias' => $alias,
            'FIND_IN_SET(?, actions) > 0' => $action,
        );
        if ($scope) {
            $conditions['FIND_IN_SET(?, scope) > 0'] = $scope;
        }
        $conditions['or'][] = array(
            'and' => array(
                'PermissionRoleMapping.school_id IS NULL',
                'PermissionRoleMapping.department_id IS NULL'
            ),
        );
        if ($schoolId) {
            $conditions['or'][] = array(
                'and' => array(
                    'PermissionRoleMapping.school_id' => $schoolId,
                    'PermissionRoleMapping.department_id IS NULL'
                ),
            );
        }
        if ($departmentId) {
            $conditions['or'][] = array(
                'and' => array(
                    'PermissionRoleMapping.school_id' => $schoolId,
                    'PermissionRoleMapping.department_id' => $departmentId
                )
            );
        }
        
        $identifier = serialize($conditions);
        $hash = md5($identifier);
        $key = 'permission-role-mapping-check-' . $hash;
        
        Cache::set(array('duration' => '+1 hour'));
        $data = Cache::read($key);
        if ($data !== false) {
            $this->log('Permission role mappings for \'' . $identifier . '\' from cache', LOG_INFO, 'permission-role-mappings');
            
            return $data;
        }
        
        $data = $this->find('all', array(
            'order' => array(
                'preference'
            ),
            'recursive' => 2,
            'conditions' => $conditions
        ));
        
        Cache::set(array('duration' => '+1 hour'));
        Cache::write($key, $data);
        
        $this->log('Permission role mappings for \'' . $identifier . '\' stored in the cache', LOG_INFO, 'permission-role-mappings');
        
        //print_r($conditions);
        return $data;
    }
    
}
