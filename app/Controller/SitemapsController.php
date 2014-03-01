<?php 

class SitemapsController extends AppController { 

    public $name = 'Sitemaps'; 
    public $uses = array('Department', 'ScheduleEntry'); 
    public $helpers = array('Time'); 
    public $components = array('RequestHandler'); 

    public function index() {     
        $this->set('departments', $this->Department->find('all'));
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
