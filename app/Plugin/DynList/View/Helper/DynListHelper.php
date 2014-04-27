<?php

class DynListHelper extends AppHelper {
	
	public $helpers = array('Html');

	protected $_initialized = false;
	
	public function addSource($source, $route) {
		if (!$this->_initialized) {
			$this->_initialize();
		}

		$parameters = array_map('json_encode', array(
			$source, str_replace('ID', '[id]', Router::url($route))
		));
		
		return $this->Html->scriptBlock(
			'DynList.addSource(' . implode(', ', $parameters) . ')'
			//array('inline' => false)
		);
	}
	
	protected function _initialize() {
		$this->Html->script('DynList.dynlist', array('inline' => false));
		$this->Html->css('DynList.dynlist', array('inline' => false));
		
		$this->_initialized = true;
	}

}