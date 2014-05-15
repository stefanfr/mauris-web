<?php

Router::connect('/', array('plugin' => 'website', 'controller' => 'home', 'action' => 'index'));
Router::promote();

Router::connect('/contribute', array('plugin' => 'website', 'controller' => 'contributions', 'action' => 'contribute'));
Router::connect('/contribute/*', array('plugin' => 'website', 'controller' => 'contributions', 'action' => 'info'));
Router::connect('/contributions/*', array('plugin' => 'website', 'controller' => 'contributions'));

Router::connect('/organizations/:action/*', array('plugin' => null, 'controller' => 'organizations', 'website' => true));
Router::connect('/organizations/*', array('plugin' => null, 'controller' => 'organizations', 'action' => 'index', 'website' => true));