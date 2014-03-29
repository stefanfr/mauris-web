<?php

class PermissionCheckComponent extends Component {

    public $components = array('Auth', 'Acl', 'SchoolInformation');

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

        return in_array($scope, $this->getScopes($permission, $action));
    }

    public function getScopes($permission, $action) {
        DebugTimer::start('component-permission-check-lookup', __('Looking up %2$s permission for %1$s', $permission, $action));

        $permissionData = array(
            'permission' => $permission,
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