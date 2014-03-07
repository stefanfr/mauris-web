<?php 

class SitemapsController extends AppController { 

    public $name = 'Sitemaps'; 
    public $uses = array('Department', 'ScheduleEntry', 'Post', 'Page');
    public $helpers = array('Time'); 
    public $components = array('RequestHandler'); 

    public function index() {     
        $this->set('departments', $this->Department->find('all'));
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
        $scheduleEntries = $this->ScheduleEntry->find(
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
        );
        foreach ($scheduleEntries as &$entry) {
            $entry['url'] = Router::url(array('controller' => 'schedule', 'action' => 'view', $entry['ScheduleEntry']['id']), true);
        }
        $this->set('schedule-entries', $scheduleEntries);
        
        //debug logs will destroy xml format, make sure were not in drbug mode 
        Configure::write ('debug', 0); 
    } 
} 
