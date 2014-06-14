<?php

App::uses('AppHelper', 'View/Helper');

class GravatarHelper extends AppHelper {

    public $helpers = array('Html');

    public function gravatar($hash, array $gravatarOptions = array(), array $options = array()) {

        return $this->Html->image($this->avatarUrl($hash, $gravatarOptions), array_merge($options, array('alt' => 'CakePHP')));
    }

	public function avatarUrl($hash, array $gravatarOptions = array()) {
		if (strlen($hash) !== 32) {
			$hash = md5(strtolower(trim($hash)));
		}

		$url = 'http://www.gravatar.com/avatar/';
		$url .= $hash;
		$url .= '?' . http_build_query($gravatarOptions);

		return $url;
	}

}
