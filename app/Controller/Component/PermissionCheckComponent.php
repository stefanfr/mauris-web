<?php

class PermissionCheckComponent extends Component {

    public $components = array('Auth', 'Acl', 'SchoolInformation');
    
    public $defaults = array(
        'global_lookup' => array()
    );
    
    public function initialize(\Controller $controller) {
        $this->settings = array_merge($this->defaults, $this->settings);
    }

    public function checkPermission($permission, $action, $scope = null) {
        if (!$scope) {
            if ($this->SchoolInformation->isSchoolIdAvailable()) {
                $scope = 'school';

                if ($this->SchoolInformation->isDepartmentIdAvailable()) {
                    $scope = 'department';
                }
            } else {
                $scope = 'system';
            }
        }
        
        $permissionScopes = $this->getScopes($permission, $action);
        
        $scopes = array();
        if (!(bool) array_filter($permissionScopes, 'is_array')) {
            $scopes = $permissionScopes;
        } elseif (!(bool) array_filter($permissionScopes, 'is_string')) {
            foreach ($permissionScopes as $permissionScope) {
                $scopes = array_merge($scopes, $permissionScope['scopes']);
            }
        }

        return in_array($scope, $scopes);
    }

    public function getScopes($permission, $action) {
        DebugTimer::start('component-permission-check-lookup', __('Looking up %2$s permission for %1$s', $permission, $action));
        
        $permissionData = array(
            'permission' => $permission,
            'global_lookup' => $this->settings['global_lookup'],
        );
        if ($this->SchoolInformation->isSchoolIdAvailable()) {
            $permissionData['school_id'] = $this->SchoolInformation->getSchoolId();
        }
        if ($this->SchoolInformation->isDepartmentIdAvailable()) {
            $permissionData['department_id'] = $this->SchoolInformation->getDepartmentId();
        }

        $scopes = $this->Acl->check(
            $this->getRequester(), $permissionData, $action
        );

        DebugTimer::stop('component-permission-check-lookup');

        return $scopes;
    }

    public function getRequester() {
        if ($this->Auth->user()) {
            $requester = 'user::' . $this->Auth->user('id');
        } else {
            $requester = 'role::anonymous';
        }

        return $requester;
    }

}