<?php

Router::connect('/schedule/*',
	array(
		'plugin'     => 'schedule',
		'controller' => 'schedule',
		'action'     => 'index',
	),
	array(
		'named' => array(
			'teacher',
			'class',
			'classroom',
			'type',
			'page',
			'limit',
			'start',
			'end'
		),
	)
);