<?php

class I18nHelper extends AppHelper {

	public function element($element) {
		$path = implode(DS, array(
			$this->_View->viewPath,
			$element
		));
		$i18nPath = implode(DS, array(
			$this->_View->viewPath,
			$element . '.' . Configure::read('Config.language')
		));

		if ($this->_View->elementExists($i18nPath)) {
			return $this->_View->element($i18nPath);
		} else {
			return $this->_View->element($path);
		}
	}

}