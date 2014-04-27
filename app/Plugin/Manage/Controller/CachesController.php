<?php

class CachesController extends ManageAppController {
    
	public $helpers =  array(
		'DynList.DynList'
	);

    public function index() {
		$this->set('can_delete', $this->PermissionCheck->checkPermission(
			'cache', 'delete', 'system'
		));
		$this->set('can_read', $this->PermissionCheck->checkPermission(
			'cache', 'read', 'system'
		));
		$this->set('configurations', Cache::configured());
    }
	
	public function view($configuration) {
		if (!$this->PermissionCheck->checkPermission('cache', 'read', 'system')) {
			throw new ForbiddenException();
		}
		
		if ($this->request->query('dynlist')) {
			$this->layout = false;
		}

		$this->set('configuration_name', $configuration);
		$this->set('configuration', Cache::config($configuration));
	}
    
    public function clear($configuration = null) {
		if (!$this->PermissionCheck->checkPermission('cache', 'delete', 'system')) {
			throw new ForbiddenException();
		}
		if ($this->request->is('post')) {
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
    }
	
	public function gc($configuration = null) {
		if (!$this->PermissionCheck->checkPermission('cache', 'update', 'system')) {
			throw new ForbiddenException();
		}
		if ($this->request->is('post')) {
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
    
}