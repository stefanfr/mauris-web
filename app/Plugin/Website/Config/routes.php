<?php

Router::connect('/', array('plugin' => 'website', 'controller' => 'home', 'action' => 'index'));
Router::promote();

Router::connect('/contribute', array('plugin' => 'website', 'controller' => 'contributions', 'action' => 'contribute'));
Router::connect('/contribute/*', array('plugin' => 'website', 'controller' => 'contributions', 'action' => 'info'));

Router::connect('/organizations', array('plugin' => 'website', 'controller' => 'organizations', 'action' => 'index'));