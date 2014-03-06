<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Page', 'Classroom', 'Post', 'TeacherAbsenceReport');

        public function beforeFilter() {
            parent::beforeFilter();

            $this->Auth->allow('show');
        }

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function display() {    
            if ($this->Auth->user()) {
                $requester = 'user::' . $this->Auth->user('id');
            } else {
                $requester = 'role::anonymous';
            }
            $allowedPostScopes = $this->Acl->check(
                $requester, array('permission' => 'post', 'school_id' => $this->School->id, 'department_id' => $this->Department->id), 'read'
            );

            $path = func_get_args();

            $count = count($path);
            if (!$count) {
                    return $this->redirect('/');
            }
            $page = $subpage = $title_for_layout = null;

            if (!empty($path[0])) {
                    $page = $path[0];
            }
            if (!empty($path[1])) {
                    $subpage = $path[1];
            }
            if (!empty($path[$count - 1])) {
                    $title_for_layout = Inflector::humanize($path[$count - 1]);
            }
            $this->set(compact('page', 'subpage', 'title_for_layout'));
            $this->set('classrooms_available_timestamp', $classroomsAvailableTimestamp = time());
            $this->set('classrooms_available', $this->Classroom->getAvailableClassrooms($classroomsAvailableTimestamp, $this->Department->id));
            $this->set('classrooms_available', $this->Classroom->getAvailableClassrooms($classroomsAvailableTimestamp, $this->Department->id));
            $this->set('latest_post', $this->Post->getLatestPost($allowedPostScopes, $this->School->id, $this->Department->id));
            $this->set('absent_teachers', $this->TeacherAbsenceReport->getAbsentTeachers(time(), strtotime('+7 days', time()), $this->Department->id));
            $this->set('school', $this->School->read());
            $this->set('department', $this->Department->read());

            try {
                $this->render(implode('/', $path));
            } catch (MissingViewException $e) {
                if (Configure::read('debug')) {
                        throw $e;
                }
                throw new NotFoundException();
            }
	}

    public function show($id = null, $slug = null) {
        $this->Page->id = $id;
        if (!$page = $this->Page->read()) {
            throw new NotFoundException();
        }

        if (Inflector::slug($page['Page']['title']) != $slug) {
            return $this->redirect(array($id, Inflector::slug($page['Page']['title'])), 301);
        }

        $this->set('page', $page);

        $body = preg_replace_callback(
            '/<a(.*)href="([^"]*)"(.*)>/',
            function ($matches) {
                $output = '';
                $output .= '<a';
                $output .= $matches[1];
                $output .= 'href="'
                    . Router::url(
                        array(
                            'plugin' => 'intermediary',
                            'controller' => 'intermediary',
                            'action' => 'check',
                            'url' => urlencode($matches[2])
                        )
                    )
                    . '"';
                $output .= $matches[3];
                $output .= '>';
                return $output;
            },
            $page['Page']['body']
        );

        $this->set(compact('body'));
    }
}
