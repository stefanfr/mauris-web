<?php

class CachesController extends AppController {
    
	public $helpers =  array(
		'DynList.DynList'
	);

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Security->requirePost('admin_clear');
		$this->Security->requirePost('admin_gc');
	}


	public function admin_index() {
		$this->set('can_delete', $this->PermissionCheck->checkPermission(
			'cache', 'delete', 'system'
		));
		$this->set('can_read', $this->PermissionCheck->checkPermission(
			'cache', 'read', 'system'
		));
		$this->set('configurations', Cache::configured());
    }

	public function admin_view($configuration) {
		if (!$this->PermissionCheck->checkPermission('cache', 'read', 'system')) {
			throw new ForbiddenException();
		}
		
		if ($this->request->query('dynlist')) {
			$this->layout = false;
		}

		$this->set('configuration_name', $configuration);
		$this->set('configuration', Cache::config($configuration));
	}

	public function admin_clear($configuration = null) {
		if (!$this->PermissionCheck->checkPermission('cache', 'delete', 'system')) {
			throw new ForbiddenException();
		}

		if ($configuration) {
			$result = Cache::clear(false, $configuration);
		} else {
			$result = Cache::clear(false);
		}

        if ($result) {
                $this->Session->setFlash(__('The caches have been cleared'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));

                return $this->redirect(array('action' => 'index'));
        }
    }

	public function admin_gc($configuration = null) {
		if (!$this->PermissionCheck->checkPermission('cache', 'update', 'system')) {
			throw new ForbiddenException();
		}

		if ($configuration) {
			Cache::gc($configuration);
		} else {
			Cache::gc();
		}

		$this->Session->setFlash(__('The garbage collector has run successfully'), 'alert', array(
			'plugin' => 'BoostCake',
			'class' => 'alert-success'
		));

		if ($configuration) {
			$route = array('action' => 'view', $configuration);
		} else {
			$route = array('action' => 'index');
		}
		return $this->redirect($route);
    }
    
}