<?php

App::uses('Component', 'Controller/Component');

class InstallComponent extends Component {

	/**
	 * @var Controller
	 */
	protected $_Controller;

	public function startup(Controller $controller) {
		$this->_Controller = $controller;
	}


	public function check() {
		$entries = array();

		$valid = true;
		$message = __('All %1$s are set-up correctly.', Inflector::pluralize($this->_Controller->modelKey));

		$existing = array_flip($this->_Controller->{$this->_Controller->modelClass}->find('list', array(
			'fields' => array('id', $this->settings['unique'])
		)));
		foreach ($this->settings['data'] as $data) {
			$installed = isset($existing[$data[$this->_Controller->modelClass][$this->settings['unique']]]);
			if (!$installed) {
				$valid = false;

				$message = __(
					'%1$s %2$s doesn\'t exist.',
					$this->_Controller->modelClass,
					$data[$this->_Controller->modelClass][$this->settings['title']]
				);

			}

			$entries[] = array(
				'title'     => $data[$this->_Controller->modelClass][$this->settings['title']],
				'data'      => $data[$this->_Controller->modelClass],
				'installed' => $installed
			);
		}

		$this->_Controller->set(array(
			'valid'      => $valid,
			'message'    => $message,
			'entries'    => $entries,
			'_serialize' => array('valid', 'message', 'entries')
		));
	}

}