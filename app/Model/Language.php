<?php

class Language extends AppModel {
    
    public $displayField = 'name';

	public function getCode($id) {
		$cacheKey = 'language-' . $id . '-code';

		$code = Cache::read($cacheKey);
		if ($code !== false) {
			return $code;
		}

		$code = $this->field('code', array(
			$this->alias . '.id' => $id
		));

		Cache::write($cacheKey, $code);

		return $code;
	}
    
}