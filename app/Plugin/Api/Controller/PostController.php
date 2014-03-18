<?php
class PostController extends AppController {

    public $components = array(
        'RequestHandler', 'ThemeAware', 'SchoolInformation',
        'DataFilter' => array(
            'supported' => array(
                'limit'
            )
        )
    );
    public $uses = array('Post');

    public function index() {
        if (isset($this->request->query['language'])) {
            Configure::write('Config.language', $this->request->query['language']);
        }
        $conditions = array();
        $conditions['and']['Post.published'] = true; 
        $conditions['and']['or'][] = array(
            'and' => array(
                'Post.school_id IS NULL',
                'Post.department_id IS NULL'
            )
        );
        if ($this->SchoolInformation->isSchoolIdAvailable()) {
            $conditions['and']['or'][] = array(
                'and' => array(
                    'Post.school_id' => $this->SchoolInformation->isSchoolIdAvailable(),
                    'Post.department_id IS NULL'
                )
            );
        }
        if ($this->SchoolInformation->isDepartmentIdAvailable()) {
            $conditions['and']['or'][] = array(
                'and' => array(
                    'Post.school_id' => $this->SchoolInformation->isSchoolIdAvailable(),
                    'Post.department_id' => $this->SchoolInformation->isDepartmentIdAvailable(),
                )
            );
        }
        $findParameters = array(
            'recursive' => 2,
            'conditions' => $conditions,
            'order' => array(
                'Post.created DESC'
            )
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

}
