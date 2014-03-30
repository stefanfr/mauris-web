<?php

Router::connect('/', array('plugin' => 'website', 'controller' => 'home', 'action' => 'index'));
Router::promote();

Router::connect('/organizations', array('plugin' => 'website', 'controller' => 'organizations', 'action' => 'index'));