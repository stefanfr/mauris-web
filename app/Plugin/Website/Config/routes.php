<?php

Router::connect('/', array('controller' => 'home', 'action' => 'index', 'website' => true));
Router::promote();

Router::connect('/contribute', array('plugin' => 'website', 'controller' => 'contributions', 'action' => 'contribute'));
Router::connect('/contribute/*', array('plugin' => 'website', 'controller' => 'contributions', 'action' => 'info'));
Router::connect('/contributions/*', array('plugin' => 'website', 'controller' => 'contributions'));

Router::connect('/organizations/:action/*', array('plugin' => null, 'controller' => 'organizations', 'website' => true));
Router::connect('/organizations/*', array('plugin' => null, 'controller' => 'organizations', 'action' => 'index', 'website' => true));