<?php

class GravatarHelper extends AppHelper {

    public $helpers = array('Html');

    public function gravatar($hash, array $gravatarOptions = array(), array $options = array()) {
        if (strstr('@', $hash)) {
			$hash = md5(strtolower(trim($hash)));
		}

		$url = 'http://www.gravatar.com/avatar/';
        $url .= $hash;
        $url .= '?' . urlencode(http_build_query($gravatarOptions));
        return $this->Html->image($url, array_merge($options, array('alt' => 'CakePHP')));
    }

}
