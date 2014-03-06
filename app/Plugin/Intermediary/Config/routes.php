<?php

Router::connect('/check/:url',
    array(
        'plugin' => 'intermediary',
        'controller' => 'intermediary',
        'action' => 'check'
    ),
    array(
        'pass' => array('url'),
        'url' => '.*'
    )
);
Router::promote();