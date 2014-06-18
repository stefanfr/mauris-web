<?php

class ModelFlashComponent extends Component {

	public $components = array('Session');

	function __call($name, $arguments) {
		$this->Session->setFlash($arguments[0], 'alert', array(
			'plugin' => 'BoostCake',
			'class' => 'alert-' . $name
		));
	}


}