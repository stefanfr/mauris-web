<?php

App::uses('AppController', 'Controller');

/**
 * Class StylesController
 *
 * @property Style Style
 * @property PaginatorComponent Paginator
 */
class StylesController extends AppController {

	public $components = array(
		'Paginator' => array(
			'settings' => array(
				'limit' => 5,
				'order' => array(
					'Style.name ASC',
				)
			)
		),
		'Security'
	);

	public function admin_index() {
		if (!$this->PermissionCheck->checkPermission('style', 'read', 'system')) {
			throw new ForbiddenException();
		}

		$this->set('styles', $this->Paginator->paginate('Style'));
	}

	public function admin_view($id) {
		$this->Style->id = $id;

		if (!$this->PermissionCheck->checkPermission('style', 'read', 'system')) {
			throw new ForbiddenException();
		}

		$style = $this->Style->read();
		if (empty($style)) {
			throw new NotFoundException();
		}

		$this->set(compact('style'));
	}

	public function admin_edit($id) {
		$this->Style->id = $id;

		if (!$this->PermissionCheck->checkPermission('style', 'update', 'system')) {
			throw new ForbiddenException();
		}

		$style = $this->Style->read();
		if (empty($style)) {
			throw new NotFoundException();
		}

		if (!$this->request->data) {
			$this->request->data = $style;
		}

		$styles = $this->Style->find('list', array(
			'fields'     => array('id', 'title', 'UsedBySchool.name'),
			'recursive'  => 2,
			'conditions' => array(
				'or' => array(
					'Style.id !=' => $style['Style']['id']
				)
			),
		));
		$schools = $this->Style->UsedBySchool->find('list');

		$this->set(compact('style', 'styles', 'schools'));

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Style->save($this->request->data)) {
				Cache::clearGroup('style');

				$this->Session->setFlash(__('The style has been changed'), 'alert', array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-success'
				));

				return;
			}

			$this->Session->setFlash(__('Could not change the style'), 'alert', array(
				'plugin' => 'BoostCake',
				'class'  => 'alert-danger'
			));
		}
	}

}