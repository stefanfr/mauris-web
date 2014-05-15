<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

if ((isset($_SERVER['HTTP_HOST'])) && ($_SERVER['HTTP_HOST'] == 'api.ictcollege.eu')) {
	//Router::mapResources('plugin.schedule');
	Router::parseExtensions();
	//Router::connect('/api/:controller/:action/*', array('plugin' => 'api'));
	//Router::connect('/api/:controller/*', array('plugin' => 'api', 'action' => 'index'));
	//Router::connect('/api/*', array('plugin' => 'api', 'controller' => 'index', 'action' => 'index'));
	Router::connect('/', array('plugin' => 'api', 'controller' => 'index', 'action' => 'index'));
	Router::connect('/:controller', array('plugin' => 'api', 'action' => 'index'));
	Router::connect('/:controller/:action/*', array('plugin' => 'api'));
} else {    
    
    Router::parseExtensions('json', 'xml', 'rss', 'css', 'html'); 
    
//Router::connect('/api/:controller/:action/*', array('plugin' => 'api'));
//Router::connect('/api/:controller/*', array('plugin' => 'api', 'action' => 'index'));
//Router::connect('/api/*', array('plugin' => 'api', 'controller' => 'index', 'action' => 'index'));

    Router::connect('/schedule/view/:id',
                array('controller' => 'schedule', 'action' => 'view'),
                array(
                    'pass' => array('id'),
                    'id' => '[0-9]+'
                )
        );
    
    /*Router::connect('/schedule/*',
            array(
                'controller' => 'schedule', 'action' => 'index',
                'type' => 'calendar'
            ),
            array(
                'named' => array(
                    'teacher',
                    'class',
                    'classroom',
                ),
            )
    );*/
    
    /*Router::connect('/schedule/:type',
            array(
                'controller' => 'schedule', 'action' => 'index',
                'type' => 'calendar'
            ),
            array(
                'named' => array(
                    'teacher',
                    'class',
                    'classroom',
                ),
                'type' => '(calendar|simple)'
            )
    );*/
    /*Router::connect('/schedule/:action/:type/*',
            array(
                'controller' => 'schedule', 'action' => 'index',
                'type' => 'calendar'
            ),
            array(
                'named' => array(
                    'teacher',
                    'class',
                    'classroom',
                ),
                'type' => '(calendar|simple)'
            )
    );
    Router::connect('/schedule/:type/*',
            array(
                'controller' => 'schedule', 'action' => 'index',
                'type' => 'calendar'
            ),
            array(
                'named' => array(
                    'teacher',
                    'class',
                    'classroom',
                ),
                'type' => '(calendar|simple)'
            )
    );*/
    
    /*Router::connect('/posts/*',
            array(
                'controller' => 'posts', 'action' => 'index',
                //'type' => 'calendar'
            ),
            array(
                'named' => array(
                    'page',
                    'limit',
                ),
            )
    );*/

	Router::connect('/manage', array('controller' => 'home', 'prefix' => 'manage'));
	Router::connect('/admin', array('controller' => 'home', 'admin' => true));

	/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
	Router::connect('/home', array('controller' => 'pages', 'action' => 'display', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */

Router::connect('/pages/custom/*', array('controller' => 'pages', 'action' => 'show'));
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
}
