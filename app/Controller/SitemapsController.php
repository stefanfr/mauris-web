<?php 

class SitemapsController extends AppController { 

    public $name = 'Sitemaps'; 
    public $uses = array('ScheduleEntry', 'Post', 'Page');
    public $helpers = array('Time'); 
    public $components = array('RequestHandler'); 

    public function index() {     
        $sitemaps = array(
            'posts', 'schedule_entries', 'pages', 'other'
        );
        $this->set('sitemaps', $sitemaps);
    }

    public function view($data) {
        switch (Inflector::slug($data)) {
            case 'posts':
                $this->set('posts', $this->Post->find(
                    'all',
                    array(
                        'recursive' => -1,
                        'conditions' => array(
                            'and' => array(
                                array(
                                    'or' => array(
                                        array(
                                            'and' => array(
                                                'school_id IS NULL',
                                                'department_id IS NULL'
                                            )
                                        ),
                                        array(
                                            'and' => array(
                                                'school_id' => $this->School->id,
                                                'department_id IS NULL'
                                            )
                                        ),
                                        array(
                                            'and' => array(
                                                'school_id' => $this->School->id,
                                                'department_id' => $this->Department->id
                                            )
                                        )
                                    )
                                ),
                                'published' => 1,
                            )
                        ),
                        'fields' => array(
                            'id', 'title'
                        )
                    )
                ));
                break;
            case 'schedule_entries':
                $this->set('schedule_entries', $this->ScheduleEntry->find(
                    'all',
                    array(
                        'recursive' => -1,
                        'conditions' => array(
                            'department_id' => $this->Department->id
                        ),
                        'fields' => array(
                            'id'
                        )
                    )
                ));
                break;
            case 'pages':
                $this->set('pages', $this->Page->find(
                    'all',
                    array(
                        'recursive' => -1,
                        'conditions' => array(
                            'and' => array(
                                array(
                                    'or' => array(
                                        array(
                                            'and' => array(
                                                'school_id' => $this->School->id,
                                                'department_id' => $this->Department->id
                                            )
                                        )
                                    )
                                ),
                            )
                        ),
                        'fields' => array(
                            'id', 'title'
                        )
                    )
                ));
                break;
            case 'other':
                $pages = array(
                    array(
                        'title' => __('Home'),
                        'route' => array('controller' => 'pages', 'action' => 'display', 'home'),
                    ),
                    array(
                        'title' => __('Organization'),
                        'route' => array('controller' => 'pages', 'action' => 'display', 'organization'),
                    ),
                    array(
                        'title' => __('News'),
                        'route' => array('controller' => 'posts', 'action' => 'index'),
                    ),
                );

                $this->set('pages', $pages);

                break;
            default:
                throw new NotFoundException();
        }

        $this->view = Inflector::slug($data);
    }
} 
