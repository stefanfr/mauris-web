<?php

App::uses('AclInterface', 'Controller/Component/Acl');

class ScheduleAcl extends Object implements AclInterface {
    
    public function __construct() {
        $this->Role = ClassRegistry::init(array('class' => 'Role', 'alias' => 'Role'));
        $this->Permission = ClassRegistry::init(array('class' => 'Permission', 'alias' => 'Permission'));
        $this->PermissionRoleMapping = ClassRegistry::init(array('class' => 'PermissionRoleMapping', 'alias' => 'PermissionRoleMapping'));
        $this->UserRoleMapping = ClassRegistry::init(array('class' => 'UserRoleMapping', 'alias' => 'UserRoleMapping'));
        $this->User = ClassRegistry::init(array('class' => 'User', 'alias' => 'User'));
    }
    
    public function allow($aro, $aco, $action = "*") {
        debug($aro);
        debug($aco);
        debug($action);
        
        $role = $this->Role->findBySystemAlias($aro);
        
        $permissions = array();
        if (is_array($aco)) {
            if (isset($aco['permission'])) {
                $permissions = $aco['permission'];
            } else {
                $permissions = $aco;
            }
            if (isset($aco['preference'])) {
                $preference = (int) $aco['preference'];
            }
        } else {
            $permissions = array($aco);
        }
        
        $mappings = array();
        foreach ($permissions as $permission) {
            $permission = $this->Permission->findBySystemAlias($permission);
            debug($permission);
            $mapping = array();
            $mapping['role_id'] = $role['Role']['id'];
            $mapping['permission_id'] = $permission['Permission']['id'];
            if (isset($preference)) {
                $mapping['preference'] = $preference;
            }
            $mapping['action'] = 'allow';
            $mappings[] = $mapping;
        }
        
        //print_r($target);
        
        //print_r($this->Role->findBySystemAlias($aro));
        //print_r($this->Permission->getPermissionsByAlias($target['permissions']));
        
        foreach ($mappings as $mapping) {
            debug($mapping);
            $this->PermissionRoleMapping->create();
            $this->PermissionRoleMapping->save($mapping);
        }
    }
    
    public function deny($aro, $aco, $action = "*") {
        
    }
    
    public function inherit($aro, $aco, $action = "*") {
        
    }

    public function check($aro, $aco, $action = "*") {
        $target = explode('::', $aro);
        if (count($target) == 1) {
            $target['type'] = 'role';
            $target['id'] = $target[0];
        } else {
            $target['type'] = $target[0];
            $target['id'] = $target[1]; 
        }
        
        if (is_array($aco)) {
            if (isset($aco['permission'])) {
                $permission = $aco['permission'];
            }
            if (isset($aco['scope'])) {
                $scope = $aco['scope'];
            }
            if (isset($aco['preference'])) {
                $preference = (int) $aco['preference'];
            }
            if (isset($aco['school_id'])) {
                $schoolId = (int) $aco['school_id'];
            }
            if (isset($aco['department_id'])) {
                $departmentId = (int) $aco['department_id'];
            }
        } else {
            list($permission, $scope) = explode('::', $aco);
        }
        
        $roles = array();
        if ($target['type'] == 'role') {
            if (is_string($target['id'])) {
                $role = $this->Role->findBySystemAlias($target['id']);
                $roles[] = $role['Role']['id'];
            } elseif (is_int($target['id'])) {
                $roles[] = $target['id'];
            }
        } elseif ($target['type'] == 'user') {
            $user = null;
            if (ctype_digit($target['id'])) {
                $user = (int) $target['id'];
            } elseif (is_string($target['id'])) {
                $userData = $this->User->findByUsername($target['id']);
                $user = $userData['User']['id'];
            }
            
            $conditions = array(
                'user_id' => $user
            );
            /*if ((!isset($schoolId)) || (!isset($departmentId))) {
                if (!isset($schoolId)) {
                    $conditions[] = 'UserRoleMapping.school_id IS NULL';
                }
                if (!isset($departmentId)) {
                    $conditions[] = 'UserRoleMapping.department_id IS NULL';
                }
            } else {*/
                if ((isset($aco['global_lookup'])) && (in_array($permission, $aco['global_lookup']))) {
                    
                } else {
                    $conditions['or'][] = array(
                        'and' => array(
                            'UserRoleMapping.school_id IS NULL',
                            'UserRoleMapping.department_id IS NULL'
                        ),
                    );
                    if (isset($departmentId)) {
                        $conditions['or'][] = array(
                            'and' => array(
                                'UserRoleMapping.school_id' => $schoolId,
                                'UserRoleMapping.department_id' => $departmentId
                            )
                        );
                    } else {
                        if (isset($schoolId)) {
                            $conditions['or'][] = array(
                                'and' => array(
                                    'UserRoleMapping.school_id' => $schoolId,
                                )
                            );
                        }
                    }
                }
                
            //}
            
            //print_r($conditions);
            
            $userRoleMappings = $this->UserRoleMapping->find(
                'all',
                array(
                    'conditions' => $conditions
                )
            );
            //print_r($userRoleMappings);
            foreach ($userRoleMappings as $userRoleMapping) {
                $roles[] = $userRoleMapping['Role']['id'];
            }
        }
        //print_r($role);
        $permissionRoleMappings = @$this->PermissionRoleMapping->getPermissionsForCheck($roles, $permission, $action, $scope, $schoolId, $departmentId);
        
        //print_r($permissionRoleMappings);
        
        $allow = false;
        $scopes = array();
        $this->log('Permission request about: ' . $permission, 'info', 'permissions');
        foreach ($permissionRoleMappings as $index => $permissionRoleMapping) {
            $allow = (bool) $permissionRoleMapping['PermissionRoleMapping']['allow'];
            if ((isset($aco['global_lookup'])) && (in_array($permission, $aco['global_lookup']))) {
                //debug($permissionRoleMapping);
                $scopes[$index]['PermissionRoleMapping'] = $permissionRoleMapping['PermissionRoleMapping'];
                $mappingScopes = explode(',', $permissionRoleMapping['PermissionRoleMapping']['scope']);
                foreach ($mappingScopes as $mappingScope) {
                    if ($allow){
                        if (!in_array($mappingScope, $scopes)) {
                            $scopes[$index]['scopes'][] = $mappingScope;
                        }
                    } else {
                        if (($key = array_search($mappingScope, $scopes[$index]['scopes'])) !== false) {
                            unset($scopes[$index]['scopes'][$key]);
                        }
                    }
                }
            } else {
                $mappingScopes = explode(',', $permissionRoleMapping['PermissionRoleMapping']['scope']);
                foreach ($mappingScopes as $mappingScope) {
                    if ($allow){
                        if (!in_array($mappingScope, $scopes)) {
                            $scopes[] = $mappingScope;
                        }
                    } else {
                        if (($key = array_search($mappingScope, $scopes)) !== false) {
                            unset($scopes[$key]);
                        }
                    }
                }
            }
            
            $this->log(
                'Role ' . $permissionRoleMapping['Role']['system_alias'] . ' ' . (($allow) ? 'allows' : 'denies') . ' ' . $permissionRoleMapping['PermissionRoleMapping']['actions'] . ' permissions on ' . $permissionRoleMapping['PermissionRoleMapping']['scope'] . ' with preference ' . $permissionRoleMapping['PermissionRoleMapping']['preference'],
                'debug',
                'permissions'
            );
        }
        
        if (!isset($scope)) {
            return $scopes;
        } else {
            return $allow;
        }
    }

    public function initialize(\Component $component) {
        //print_r($component);
    }    
}