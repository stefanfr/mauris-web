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
			    ),
			    'recursive' => 1
		    )
	    ),
	    'RequestHandler',
	    'ModelFlash',
	    'DataFilter' => array(
		    'supported' => array('limit')
	    )
    );

	public $hasMany = array(
		'Comment' => array(
			'className' => 'Comment',
			'foreignKey' => 'post_id'
		)
	);

    public $uses = array('Post', 'Comment', 'User');

	function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow(array('latest', 'overview'));
	}


	public function index() {
        $allowedScopes = $this->PermissionCheck->getScopes('post', 'read');

        if (empty($allowedScopes)) {
            throw new ForbiddenException();
        }

        $this->set('can_post', $this->PermissionCheck->checkPermission('post', 'create'));

		$this->Paginator->settings['scopes'] = $allowedScopes;
		$this->Paginator->settings['department'] = $this->SchoolInformation->getDepartmentId();
		$this->Paginator->settings['organization'] = $this->SchoolInformation->getSchoolId();

		$this->set(array(
			'posts' => $this->Paginator->paginate('Post', array(
				'Post.published' => true
			)),
			'_serialize' => array('posts')
		));
    }

	public function overview() {
		if (isset($this->request->query['language'])) {
			Configure::write('Config.language', $this->request->query['language']);
		}
		$conditions = array();
		$conditions['and']['Post.published'] = true;
		$findParameters = array(
			'recursive' => 1,
			'conditions' => array(
				'Post.published' => true
			),
			'order' => array(
				'Post.created DESC'
			),
			'department' => $this->SchoolInformation->getDepartmentId(),
			'organization' => $this->SchoolInformation->getSchoolId(),
			'scopes' => array('system', 'organization', 'department')
		);
		if ($this->DataFilter->hasLimit()) {
			$findParameters['limit'] = $this->DataFilter->getLimit();
		}
		$posts = $this->Post->find(
			'all',
			$findParameters
		);
		$this->set(array(
			'posts' => $posts,
			'_serialize' => array('posts')
		));
	}

	public function by_author($authorId) {
		$allowedScopes = $this->PermissionCheck->getScopes('post', 'read');

		if (empty($allowedScopes)) {
			throw new ForbiddenException();
		}

		$this->set('can_post', $this->PermissionCheck->checkPermission('post', 'create'));

		$this->Paginator->settings['scopes'] = $allowedScopes;
		$this->Paginator->settings['department'] = $this->SchoolInformation->getDepartmentId();
		$this->Paginator->settings['organization'] = $this->SchoolInformation->getSchoolId();

		$posts = $this->Paginator->paginate('Post', array(
			'Post.published' => true,
			'Post.user_id' => $authorId
		));

		if ($this->request->is('requested')) {
			return $posts;
		}

		$this->set(array(
			'posts' => $posts,
			'_serialize' => array('posts')
		));
	}

    public function view($id = null, $slug = null) {
	    $this->Post->recursive = 2;
	    $this->Post->id = $id;
        if (!$this->Post->exists()) {
            throw new NotFoundException();
        };

	    $post = $this->Post->read();

	    if ((!$this->request->is('rest')) && (Inflector::slug($post['Post']['title']) != $slug)) {
		    $this->redirect(array($id, Inflector::slug($post['Post']['title'])), 301);
	    }

	    $scope = $this->Post->getScope(
		    $post, $this->Auth->user('id'),
		    $this->SchoolInformation->getSchoolId(),
		    $this->SchoolInformation->getDepartmentId()
	    );

        $this->set(array(
	        'post' => $post,
	        'comments' => $this->Post->Comment->find('threaded', array(
		        'conditions' => array(
			        'Comment.post_id' => $id
		        )
	        )),
	        'can_comment' => $this->PermissionCheck->checkPermission('comment', 'create', $scope),
	        'can_view_comments' => $this->PermissionCheck->checkPermission('comment', 'read', $scope),
	        '_serialize' => array('post')
        ));
    }

	public function latest() {
		$allowedPostScopes = $this->PermissionCheck->getScopes('post', 'read');

		$latest_post = $this->Post->getLatestPost(
			$allowedPostScopes,
			$this->SchoolInformation->getSchoolId(),
			$this->SchoolInformation->getDepartmentId()
		);

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
        if (!$this->request->is('post')) {
	        return;
        }

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

        $this->Post->scope = $this->request->data['Post']['scope'];

        $this->Post->create();
        if (!$this->Post->save($this->request->data)) {
	        $this->ModelFlash->danger(__('Could not create your post'));

	        return;
        }

	    $this->ModelFlash->success(__('Your post has been created'));

	    $this->redirect(array('action' => 'index'));
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
		if (!$this->Post->delete($id)) {
			$this->ModelFlash->danger(__('Could not remove your post'));

			return;
		}

		$this->ModelFlash->success(__('Your post has been removed'));

		$this->redirect(array('action' => 'index'));
	}
}
