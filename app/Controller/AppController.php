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
 */
class AppController extends Controller {
	//public $components = array('DebugKit.Toolbar');
	
    public $uses = array('Department', 'School', 'Style');
    
    public $helpers = array(
        'Session',
        'Html' => array('className' => 'SchemaOrgHtml'),
        'Form' => array('className' => 'BoostCake.BoostCakeForm'),
        'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'),
        'Menu'
    );
    
    public $components = array(
        'DebugKit.Toolbar',
        'Session',
        'Auth' => array(
            'loginRedirect' => array(
                'controller' => 'profile',
                'action' => 'view'
            ),
            'logoutRedirect' => array(
                'controller' => 'pages',
                'action' => 'display',
                'home'
            )
        ),
        'Acl'
    );
        
    function beforeFilter() {
        $this->Auth->allow('index', 'view', 'display');
        $this->Auth->authenticate = array(
            'Form' => array(
                'userModel' => 'User',
                'passwordHasher' => 'Blowfish'
            )
        );
        
        $department = $this->Department->findByHostname($_SERVER['HTTP_HOST']);
        
        if (!empty($department)) {
            $this->Department->id = (int) $department['Department']['id'];
            $this->School->id = (int) $department['BelongingToSchool']['id'];

            if ($department['BelongingToSchool']['UsesLanguage']['code']) {
                $language = $department['BelongingToSchool']['UsesLanguage']['code'];
            }
            if ($department['UsesLanguage']['code']) {
                $language = $department['UsesLanguage']['code'];
            }
            if (isset($language)) {
                if (!$this->Session->check('Config.language')) {
                    Configure::write('Config.language', $language);
                }
            }

            $this->set('department_name', $department['Department']['name']);
            $this->set('school_name', $department['BelongingToSchool']['name']);
            
            $style = $this->Style->getStyle($department['UsesStyle']['id']);
            
            $this->set('header_background_color', $style['header_background_color']);
            $this->set('header_text_color', $style['header_text_color']);
            $this->set('header_link_color', $style['header_link_color']);
            $this->set('header_brand_color', $style['header_brand_color']);
            $this->set('header_border_color', $style['header_border_color']);
            $this->set('header_active_background_color', $style['header_active_background_color']);
            $this->set('header_active_link_color', $style['header_active_link_color']);
            $this->set('text_color', $style['text_color']);
            $this->set('link_color', $style['link_color']);
        }
        
        if ($this->Auth->user()) {
            $requester = 'user::' . $this->Auth->user('id');
        } else {
            $requester = 'role::anonymous';
        }
        $manageAllowedScopes = $this->Acl->check(
            $requester, array('permission' => 'manage', 'school_id' => $this->School->id, 'department_id' => $this->Department->id), 'read'
        );
        $this->set('can_manage', (bool) $manageAllowedScopes);
    }

}
