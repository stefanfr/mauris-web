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
        
        //print_r($conditions);
        return $this->find('all', array(
            'order' => array(
                'preference'
            ),
            'recursive' => 2,
            'conditions' => $conditions
        ));
    }
    
}
