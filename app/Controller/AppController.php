<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 * @property PermissionCheckComponent PermissionCheck
 */
class AppController extends Controller {
	//public $components = array('DebugKit.Toolbar');
	
    public $uses = array('Department', 'School', 'Style');
    
    public $helpers = array(
        'Session',
        'Html' => array('className' => 'SchemaOrgHtml'),
        'Form' => array('className' => 'BoostCake.BoostCakeForm'),
	    'ModelForm',
        'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'),
        'Menu',
        'Naming',
		'Title'
    );

	public $components = array(
		'DebugKit.Toolbar',
		'Session',
		'Auth' => array(
			'loginAction'    => array(
				'plugin'     => null,
				'controller' => 'users',
				'action'     => 'login',
				'website'    => false,
				'manage'     => false,
				'admin'      => false
			),
			'loginRedirect'  => array(
				'plugin' => null,
				'controller' => 'users',
				'action'     => 'profile',
				'website'    => false,
				'manage'     => false,
				'admin'      => false
			),
			'logoutRedirect' => array(
				'plugin'     => null,
				'controller' => 'home',
				'action'     => 'index',
				'website'    => false,
				'manage'     => false,
				'admin'      => false
			),
			'flash'          => array(
				'element' => 'alert',
				'key'     => 'auth',
				'params'  => array(
					'plugin' => 'BoostCake',
					'class'  => 'alert-danger'
				)
			)
		),
		'Acl',
		'SchoolInformation',
		'Styling',
		'LanguageAware',
		'PermissionCheck',
		'Security'
	);
        
    function beforeFilter() {
	    $this->Auth->allow('index', 'view', 'display', 'install_check', 'install_load');
        $this->Auth->authenticate = array(
            'Form' => array(
                'userModel' => 'User',
                'passwordHasher' => 'Blowfish'
            )
        );

        $this->set('can_manage', $this->PermissionCheck->checkPermission('manage', 'read'));
	    $this->set('logged_in', $this->Auth->loggedIn());
	    $this->set('current_user', $this->Auth->user());

	    $this->Security->requirePost('manage_delete');
	    $this->Security->requirePost('admin_delete');
	    $this->Security->requirePost('delete');

	    if (isset($this->params['prefix'])) {
		    switch ($this->params['prefix']) {
			    case 'manage':
			    case 'admin':
			    case 'install':
				    $this->layout = $this->params['prefix'];
		    }

		    $this->PermissionCheck->settings['global_lookup'] = array('manage', 'admin');

		    switch ($this->params['prefix']) {
			    case 'manage':
			    case 'admin':
				    if (!$this->Auth->user()) {
					    throw new UnauthorizedException();
				    }

				    $hasAccess = $this->PermissionCheck->checkPermission($this->params['prefix'], 'read');
				    if (!$hasAccess) {
					    throw new ForbiddenException();
				    }

				    break;
		    }

	    }
    }

}
