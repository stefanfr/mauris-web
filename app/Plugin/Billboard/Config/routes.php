<?php

Router::connect('/billboard', array(
	'plugin'     => 'billboard',
	'controller' => 'billboards',
	'action'     => 'display',
	'default'
));

Router::connect('/billboard/version_check.:ext', array('plugin' => 'billboard', 'controller' => 'version_check', 'action' => 'check'));