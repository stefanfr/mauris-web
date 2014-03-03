<?php

class GravatarHelper extends AppHelper {

    public $helpers = array('Html');

    public function gravatar($email, array $gravatarOptions = array(), array $options = array()) {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= '?' . urlencode(http_build_query($gravatarOptions));
        return $this->Html->image($url, array_merge($options, array('alt' => 'CakePHP')));
    }

}
