<?php
class ScheduleController extends AppController {

    public $uses = array('ScheduleEntry', 'SubjectDetails', 'ClassroomDetails', 'AClass', 'Teacher');
    
    public $components = array('Paginator');

    public $paginate = array(
        'limit' => 8,
        'recursive' => 0,
        'order' => array(
            'ScheduleEntry.date' => 'asc',
            'ScheduleEntry.period' => 'asc'
        )
    );
    
    public function index() {
        if (!$this->PermissionCheck->checkPermission('schedule', 'read')) {
            throw new ForbiddenException();
        }
        
        $this->Paginator->settings = $this->paginate;
        $this->view = (isset($this->passedArgs['type'])) ? $this->passedArgs['type'] : 'calendar';
        
        if (isset($this->request->data['teacher'])) {
            return $this->redirect(array('teacher' => $this->request->data['teacher'], 'type' => $this->view));
        }
        if (isset($this->request->data['class'])) {
            return $this->redirect(array('class' => $this->request->data['class'], 'type' => $this->view));
        }
        
        if (isset($this->passedArgs['class'])) {
            $this->set('target_class_id', $this->passedArgs['class']);
            $conditions['GivenToClass.id'] = $this->passedArgs['class'];
        }
        if (isset($this->passedArgs['teacher'])) {
            $this->set('target_teacher_id', $this->passedArgs['teacher']);
            $conditions['GivenByTeacher.id'] = $this->passedArgs['teacher'];
        }
        if (isset($this->passedArgs['classroom'])) {
            $this->set('target_classroom_id', $this->passedArgs['classroom']);
            $conditions['GivenInClassroom.id'] = $this->passedArgs['classroom'];
        }
        
        $year = date('o');
        $week = date('W');
        
        if (isset($this->passedArgs['start'])) {
            $this->set('target_start', strtotime($this->passedArgs['start']));
        } else {
            $this->set('target_start', strtotime("{$year}-W{$week}-1"));
        }
        if (isset($this->passedArgs['end'])) {
            $this->set('target_end', strtotime($this->passedArgs['end']));
        } else {
            $this->set('target_end', strtotime("{$year}-W{$week}-7"));
        }
        if (isset($this->passedArgs['date'])) {
            $this->set('target_date', strtotime($this->passedArgs['date']));
        } else {
            $this->set('target_date', time());
        }
        
        $this->set('target_school_id', $this->School->id);
        $this->set('target_department_id', $this->Department->id);

        if ($this->view == 'simple') {
            
            $conditions = array(
                'ScheduleEntry.date BETWEEN ? AND ?' => array(
                    date('Y-m-d', $this->viewVars['target_start']),
                    date('Y-m-d', $this->viewVars['target_end'])
                ),
                'ScheduleEntry.department_id' => $this->Department->id
            );
            
            if (isset($this->passedArgs['class'])) {
                $conditions['GivenToClass.id'] = $this->passedArgs['class'];
            }
            if (isset($this->passedArgs['teacher'])) {
                $conditions['GivenByTeacher.id'] = $this->passedArgs['teacher'];
            }
            if (isset($this->passedArgs['classroom'])) {
                $conditions['GivenInClassroom.id'] = $this->passedArgs['classroom'];
            }
            $entries = $this->Paginator->paginate(
                'ScheduleEntry',
                $conditions
            );
            //print_r($data);
            //$entries = $this->ScheduleEntry->getSchedule($conditions);
            
            //$calendarEvents = array();
            foreach ($entries as &$entry) {
            /*$event = array(
                'id' => $entry['ScheduleEntry']['id'],
                'url' => Router::url(array(
                    'controller' => 'schedule',
                    'action' => 'view',
                    $entry['ScheduleEntry']['id']
                )),
                'title' => (isset($entry['GivenSubject']['SubjectDetails'])) ? $entry['GivenSubject']['SubjectDetails']['title'] : $entry['GivenSubject']['abbreviation'],
                'period' => $entry['GivenInPeriod']['period'],
                'start' => strtotime($entry['ScheduleEntry']['date'] . ' ' . $entry['GivenInPeriod']['start']),
                'end' => strtotime($entry['ScheduleEntry']['date'] . ' ' . $entry['GivenInPeriod']['end']),
                'cancelled' => (bool) $entry['ScheduleEntry']['cancelled'],
                'allDay' => false,
                'class_name' => $entry['GivenToClass']['name'],
                'classroom_title' => @$entry['GivenInClassroom']['ClassroomDetails']['title'],
                'classroom_code' => $entry['GivenInClassroom']['code'],
                'subject_abbreviation' => $entry['GivenSubject']['abbreviation'],
                'subject_title' => @$entry['GivenSubject']['SubjectDetails']['title'],
                'subject_abbreviation' => $entry['GivenSubject']['abbreviation'],
                'teacher_name' => $entry['GivenByTeacher']['name'],
                'teacher_abbreviation' => $entry['GivenByTeacher']['abbreviation']
            );*/
            //$event = 
            
            /*$event['assignments'] = array();
            foreach ($entry['GivenAssignments'] as $assignmentMapping) {
                $assignment = $assignmentMapping['Assignment'];
                $event['assignments'][] = array(
                    'id' => $assignment['id'],
                    'title' => $assignment['title'],
                    'description' => $assignment['description'],
                    'state' => explode(',', $assignmentMapping['state'])
                );
            }*/
            
            //$id = ;
            //$subject = (isset($entry['GivenSubject']['SubjectDetails'])) ?  : $entry['GivenSubject']['abbreviation'];
            
            
            
            
            /*
             * $calendarEvent = array();
            $calendarEvent['id'] = $id;
            $calendarEvent['url'] = Router::url(array('controller' => 'schedule', 'action' => 'view', 'id' => $calendarEvent['id']));
            $calendarEvent['title'] = $subject;
            $calendarEvent['start'] = date('c', strtotime($entry['ScheduleEntry']['date'] . ' ' . $entry['GivenInPeriod']['start']));
            $calendarEvent['end'] = date('c', strtotime($entry['ScheduleEntry']['date'] . ' ' . $entry['GivenInPeriod']['end']));
            $calendarEvent['allDay'] = false;
            $calendarEvent['subject_name'] = (isset($subjectDetails[$entry['GivenSubject']['id']])) ? $subjectDetails[$entry['GivenSubject']['id']]['SubjectDetails']['title'] : null;
            $calendarEvent['subject_abbreviation'] = $entry['GivenSubject']['abbreviation'];
            $calendarEvent['teacher_abbreviation'] = $entry['GivenByTeacher']['abbreviation'];
             */
            
            
            
            $entry = $this->_createEntryVariables($entry);
        }
     
        
        //$recipe = $this->Recipe->findById($id);
        $this->set(array(
            'entries' => $entries,
        ));
        }
            $this->set('classes', $this->AClass->getAllClasses($this->Department->id));
            $this->set('teachers', $this->Teacher->getAllTeachers($this->Department->id));
    }
        
    public function view($id) {    
        $this->ScheduleEntry->recursive = 2;
        $this->ScheduleEntry->id = $id;
        
        $entries = $this->ScheduleEntry->getSchedule();
        $entry = $entries[0];
        
        //print_r($entry);
        
        //$entry = $this->ScheduleEntry->read();
        
        $this->set('title_for_layout', $this->SubjectDetails->field('title'));
        
        if (isset($entry['GivenSubject']['SubjectDetails'])) {
            $this->set('subject_title', $entry['GivenSubject']['SubjectDetails']['title']);
        }
        $this->set('subject_abbreviation', $entry['GivenSubject']['abbreviation']);
        
        if (isset($entry['GivenByTeacher']['name'])) {
            $this->set('teacher_name', $entry['GivenByTeacher']['name']);
            $this->set('teacher_abbreviation', $entry['GivenByTeacher']['abbreviation']);
            $this->set('teacher_url', Router::url(array('controller' => 'teacher', 'action' => 'view', $entry['GivenByTeacher']['id'])));
        }
        
        if (isset($entry['GivenInClassroom']['ClassroomDetails'])) {
            $this->set('classroom_name', $entry['GivenInClassroom']['ClassroomDetails']['title']);
        }
        $this->set('classroom_code', $entry['GivenInClassroom']['code']);
        $this->set('classroom_id', $entry['GivenInClassroom']['id']);
        $this->set('classroom_url', Router::url(array('controller' => 'classroom', 'action' => 'view', $entry['GivenInClassroom']['id'])));
        
        $this->set('class_name', $entry['GivenToClass']['name']);
        $this->set('class_url', Router::url(array('controller' => 'class', 'action' => 'view', $entry['GivenToClass']['id'])));
        
        $this->set('entry_cancelled', (bool) $entry['ScheduleEntry']['cancelled']);
        $this->set('entry_period', $entry['GivenInPeriod']['period']);
        
        $beginDate = new DateTime($entry['ScheduleEntry']['date'] . ' ' . $entry['GivenInPeriod']['start'], new DateTimeZone($entry['GivenInPeriod']['timezone']));
        $endDate = new DateTime($entry['ScheduleEntry']['date'] . ' ' . $entry['GivenInPeriod']['end'], new DateTimeZone($entry['GivenInPeriod']['timezone']));
        
        $this->set('entry_date_start', $beginDate->getTimestamp());
        $this->set('entry_date_end', $endDate->getTimestamp());
        //$period = $this->Period->findByPeriod($entry['ScheduleEntry']['period']);
        
        $assignments = array();
        foreach ($entry['GivenAssignments'] as $assignmentMapping) {
            $assignment = $assignmentMapping['Assignment'];
            $assignments[] = array(
                'id' => $assignment['id'],
                'title' => $assignment['title'],
                'description' => $assignment['description'],
                'state' => explode(',', $assignmentMapping['state'])
            );
        }
        $this->set('assignments', $assignments);
    }

    private function _createEntryVariables($entry) {
        //debug($entry);
        $vars = array();
        if (isset($entry['GivenSubject']['SubjectDetails'])) {
            $vars['subject_title'] = $entry['GivenSubject']['SubjectDetails']['title'];
        }
        $vars['subject_abbreviation'] = $entry['GivenSubject']['abbreviation'];
        
        if (isset($entry['GivenByTeacher']['name'])) {
            $vars['teacher_name'] = $entry['GivenByTeacher']['name'];
            $vars['teacher_abbreviation'] = $entry['GivenByTeacher']['abbreviation'];
            $vars['teacher_url'] = Router::url(array('controller' => 'teacher', 'action' => 'view', $entry['GivenByTeacher']['id']));
        }
        
        if (isset($entry['GivenInClassroom']['ClassroomDetails'])) {
            $vars['classroom_name'] = $entry['GivenInClassroom']['ClassroomDetails']['title'];
        }
        $vars['classroom_code'] = $entry['GivenInClassroom']['code'];
        $vars['classroom_id'] = $entry['GivenInClassroom']['id'];
        $vars['classroom_url'] = Router::url(array('controller' => 'classroom', 'action' => 'view', $entry['GivenInClassroom']['id']));
        
        $vars['class_name'] = $entry['GivenToClass']['name'];
        $vars['class_url'] = Router::url(array('controller' => 'class', 'action' => 'view', $entry['GivenToClass']['id']));
        
        $vars['id'] = (int) $entry['ScheduleEntry']['id'];
        $vars['cancelled'] = (bool) $entry['ScheduleEntry']['cancelled'];
        $vars['period'] = $entry['GivenInPeriod']['period'];
        $vars['start'] = strtotime($entry['ScheduleEntry']['date'] . ' ' . $entry['GivenInPeriod']['start']);
        $vars['end'] = strtotime($entry['ScheduleEntry']['date'] . ' ' . $entry['GivenInPeriod']['end']);
        //$period = $this->Period->findByPeriod($entry['ScheduleEntry']['period']);
        
        /*$assignments = array();
        foreach ($entry['GivenAssignments'] as $assignmentMapping) {
            $assignment = $assignmentMapping['Assignment'];
            $assignments[] = array(
                'id' => $assignment['id'],
                'title' => $assignment['title'],
                'description' => $assignment['description'],
                'state' => explode(',', $assignmentMapping['state'])
            );
        }
        $this->set('assignments', $assignments);*/
        
        return $vars;
    }
    
}
