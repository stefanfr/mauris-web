<?php

Router::connect('/billboard/version_check.:ext', array('plugin' => 'billboard', 'controller' => 'version_check', 'action' => 'check'));