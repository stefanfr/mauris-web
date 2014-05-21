<?php

App::uses('Component', 'Controller/Component');

/**
 * Class AutoPermissionComponent
 *
 * @property PermissionCheckComponent PermissionCheck
 */
class AutoPermissionComponent extends Component {

	public $components = array(
		'PermissionCheck'
	);

	public $settings = array(
		'mappings' => array(
			'create' => array('add'),
			'read'   => array('index', 'view'),
			'update' => array('edit'),
			'delete' => array('delete'),
		),
		'ignore'   => array(
			'action' => array(),
			'prefix' => array()
		)
	);

	public function __construct(ComponentCollection $collection, $settings = array()) {
		$settings = array_merge_recursive($this->settings, $settings);

		parent::__construct($collection, $settings);
	}


	public function startup(Controller $controller) {
		//region Determine the executed action
		$actionParts = explode('_', $controller->request->param('action'));
		if (($key = array_search($controller->request->param('prefix'), $actionParts)) !== false) {
			unset($actionParts[$key]);
		}
		$action = implode('_', $actionParts);
		//endregion

		//region Determine the permission action to check against
		$permissionAction = null;
		foreach ($this->settings['mappings'] as $permission => $actions) {
			if (in_array($action, $actions)) {
				$permissionAction = $permission;
			}
		}
		//endregion

		if (
			(in_array($controller->request->param('prefix'), $this->settings['ignore']['prefix'])) ||
			(in_array($action, $this->settings['ignore']['action']))
		) {
			return;
		}

		if (!$permissionAction) {
			return;
		}

		$scope = null;
		if ($controller->request->param('prefix') == 'admin') {
			$scope = 'system';
		}

		$permission = $controller->modelKey;

		debug($controller->modelKey);
		debug($permissionAction);
		debug($scope);

		if (!$this->PermissionCheck->checkPermission($permission, $permissionAction, $scope)) {
			throw new ForbiddenException();
		}
	}

}