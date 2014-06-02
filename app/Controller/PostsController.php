<?php

App::uses('AppController', 'Controller');

/**
 * Class PostsController
 *
 * @property Post Post
 * @property Comment Comment
 * @property User User
 */
class PostsController extends AppController {

    public $components = array(
	    'Session',
	    'Paginator' => array(
		    'settings' => array(
			    'limit' => 3,
			    'order' => array(
				    'Post.created' => 'DESC'
			    )
		    )
	    ),
	    'RequestHandler'
    );

    public $uses = array('Post', 'Comment', 'User');

	function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow('latest');
	}


	public function index() {
        $allowedScopes = $this->PermissionCheck->getScopes('post', 'read');

        if (empty($allowedScopes)) {
            throw new ForbiddenException();
        }

        $this->set('can_post', $this->PermissionCheck->checkPermission('post', 'create'));

        $conditions = array();
        $conditions['and']['Post.published'] = true;
        if (in_array('system', $allowedScopes)) {
            $conditions['and']['or'][] = array(
                'and' => array(
                    'Post.school_id IS NULL',
                    'Post.department_id IS NULL'
                )
            );
        }
        if (in_array('school', $allowedScopes)) {
            $conditions['and']['or'][] = array(
                'and' => array(
                    'Post.school_id' => $this->School->id,
                    'Post.department_id IS NULL'
                )
            );
        }
        if (in_array('department', $allowedScopes)) {
            $conditions['and']['or'][] = array(
                'and' => array(
                    'Post.school_id' => $this->School->id,
                    'Post.department_id' => $this->Department->id
                )
            );
        }
        if ((in_array('own', $allowedScopes)) && ($this->Auth->user())) {
            $conditions['and']['or'][] = array(
                'and' => array(
                    'Post.user_id' => $this->Auth->user('id'),
                    'Post.school_id' => $this->School->id,
                    array(
                        'or' => array(
                            'Post.department_id' => $this->Department->id,
                            'Post.department_id IS NULL'
                        )
                    )
                )
            );
        }

		$this->set(array(
			'posts' => $this->Paginator->paginate('Post', $conditions),
			'_serialize' => array('posts')
		));
    }

    public function view($id = null, $slug = null) {
	    $this->Post->recursive = 2;
        $post = $this->Post->findById($id);
        if (!$post) {
            throw new NotFoundException();
        };

	    if (!$this->request->is('rest')) {
		    if (Inflector::slug($post['Post']['title']) != $slug) {
			    return $this->redirect(array($id, Inflector::slug($post['Post']['title'])), 301);
		    }
	    }

        $scope = null;
        if ($post['PostedBy']['id'] == $this->Auth->user('id')) {
            $scope = 'own';
        } else {
            if ((!empty($post['Post']['school_id'])) && ($post['Post']['school_id'] == $this->SchoolInformation->isSchoolIdAvailable())) {
                $scope = 'school';
                if ((!empty($post['Post']['department_id'])) && ($post['Post']['department_id'] == $this->SchoolInformation->isDepartmentIdAvailable())) {
                    $scope = 'department';
                }
            } else {
                $scope = 'system';
            }
        }

        $this->set(array(
	        'post' => $post,
	        'comments' => $this->Comment->getPostComments($id),
	        'can_comment' => $this->PermissionCheck->checkPermission('comment', 'create', $scope),
	        'can_view_comments' => $this->PermissionCheck->checkPermission('comment', 'read', $scope),
	        '_serialize' => array('post')
        ));
    }

	public function latest() {
		$allowedPostScopes = $this->PermissionCheck->getScopes('post', 'read');

		$latest_post = $this->Post->getLatestPost($allowedPostScopes, $this->School->id, $this->Department->id);

		if ($this->request->is('requested')) {
			return $latest_post;
		}
	}

    public function add() {
        $allowedScopes = $this->PermissionCheck->getScopes('post', 'create');
        $this->set('allowed_scopes', $allowedScopes);
        if (empty($allowedScopes)) {
            throw new ForbiddenException();
        }
        if ($this->request->is('post')) {
            $this->request->data['Post']['user_id'] = $this->Auth->user('id');
            $this->request->data['Post']['created'] = date('Y-m-d H:i:s');

            if (!in_array($this->request->data['Post']['scope'], $allowedScopes)) {
                throw new ForbiddenException();
            }

            if ($this->request->data['Post']['scope'] == 'school') {
                $this->request->data['Post']['school_id'] = $this->School->id;
            }
            if ($this->request->data['Post']['scope'] == 'department') {
                $this->request->data['Post']['school_id'] = $this->School->id;
                $this->request->data['Post']['department_id'] = $this->Department->id;
            }

            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
                $this->Session->setFlash(__('Your post has been created'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));

                return $this->redirect(array('action' => 'index'));
            }

            $this->Session->setFlash(__('Could not create your post'), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-danger'
            ));
        }
    }

    public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException();
		}

		$post = $this->Post->findById($id);
		if (!$post) {
			throw new NotFoundException(__('Could not find this post'));
		}

		if ($this->request->is(array('post', 'put'))) {
			$this->Post->id = $id;
			if ($this->Post->save($this->request->data)) {

				$this->Session->setFlash(__('Your post has been changed'), 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-success'
				));

				return $this->redirect(array('action' => 'index'));
			}

            $this->Session->setFlash(__('Could not change your post'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-danger'
			));
		}

		if (!$this->request->data) {
			$this->request->data = $post;
		}
	}

	public function delete($id) {
		if ($this->Post->delete($id)) {
			$this->Session->setFlash(__('Your post has been removed'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-danger'
			));
					
			return $this->redirect(array('action' => 'index'));
		}

		$this->Session->setFlash(__('Could not remove your post'), 'alert', array(
			'plugin' => 'BoostCake',
			'class' => 'alert-danger'
		));
	}
}
