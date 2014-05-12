<?php
class ScheduleController extends AppController {

    public $uses = array('ScheduleEntry', 'SubjectDetails', 'ClassroomDetails', 'AClass', 'Teacher');
    
    public $components = array(
        'Paginator', 'RequestHandler', 'TimeAware',
        'DataFilter' => array(
            'custom' => array(
                'class', 'classroom', 'teacher', 'cancelled', 'view'
            )
        )
    );

    public $paginate = array(
        'limit' => 8,
        'recursive' => 2,
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

        if (!$this->request->param('ext')) {
            $this->view = (isset($this->passedArgs['type'])) ? $this->passedArgs['type'] : 'calendar';
        }

        $target = array();

        $conditions = array(
            'ScheduleEntry.date BETWEEN ? AND ?' => array(
                date('Y-m-d', $this->TimeAware->getStart()),
                date('Y-m-d', $this->TimeAware->getEnd())
            ),
            'ScheduleEntry.department_id' => $this->SchoolInformation->getDepartmentId()
        );
        $target['start'] = $this->TimeAware->getStart();
        $target['end'] = $this->TimeAware->getEnd();
        $target['date'] = $this->TimeAware->getStart();

        if ($this->DataFilter->hasCustomFilter('class')) {
            $target['class'] = $this->DataFilter->getCustomFilter('class');
            $conditions['GivenToClass.id'] = $target['class'];
        }
        if ($this->DataFilter->hasCustomFilter('teacher')) {
            $target['teacher'] = $this->DataFilter->getCustomFilter('teacher');
            $conditions['GivenToClass.id'] = $target['teacher'];
        }
        if ($this->DataFilter->hasCustomFilter('classroom')) {
            $target['classroom'] = $this->DataFilter->getCustomFilter('classroom');
            $conditions['GivenToClass.id'] = $target['classroom'];
        }

        $this->set('target', $target);

        $entries = $this->Paginator->paginate(
            'ScheduleEntry',
            $conditions
        );

        foreach ($entries as &$entry) {
            $entry = $this->_createEntryVariables($entry);
        }

        $this->set('classes', $this->AClass->getAllClasses($this->Department->id));
        $this->set('teachers', $this->Teacher->getAllTeachers($this->Department->id));

        $this->set(array(
            'events' => $entries,
            '_serialize' => array('events')
        ));
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
        $startDate = new DateTime($entry['ScheduleEntry']['date'] . ' ' . $entry['GivenInPeriod']['start'], new DateTimeZone($entry['GivenInPeriod']['timezone']));
        $endDate = new DateTime($entry['ScheduleEntry']['date'] . ' ' . $entry['GivenInPeriod']['end'], new DateTimeZone($entry['GivenInPeriod']['timezone']));
        //debug($entry);
        $vars = array();
        $vars['url'] = Router::url(array('plugin' => 'schedule', 'controller' => 'schedule', 'action' => 'view', $entry['ScheduleEntry']['id']));
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
            $vars['classroom_title'] = $entry['GivenInClassroom']['ClassroomDetails']['title'];
        }
        $vars['classroom_code'] = $entry['GivenInClassroom']['code'];
        $vars['classroom_id'] = $entry['GivenInClassroom']['id'];
        $vars['classroom_url'] = Router::url(array('controller' => 'classroom', 'action' => 'view', $entry['GivenInClassroom']['id']));
        
        $vars['class_name'] = $entry['GivenToClass']['name'];
        $vars['class_url'] = Router::url(array('controller' => 'class', 'action' => 'view', $entry['GivenToClass']['id']));
        
        $vars['id'] = (int) $entry['ScheduleEntry']['id'];
        $vars['cancelled'] = (bool) $entry['ScheduleEntry']['cancelled'];
        $vars['period'] = $entry['GivenInPeriod']['period'];
        $vars['start'] = strtotime($startDate->format(DateTime::ISO8601));
        $vars['end'] = strtotime($endDate->format(DateTime::ISO8601));
        $vars['allDay'] = false;
        //$period = $this->Period->findByPeriod($entry['ScheduleEntry']['period']);

        $vars['assignments'] = array();
        foreach ($entry['GivenAssignments'] as $assignmentMapping) {
            $assignment = $assignmentMapping['Assignment'];
            $vars['assignments'][] = array(
                'id' => $assignment['id'],
                'title' => $assignment['title'],
                'description' => $assignment['description'],
                'state' => explode(',', $assignmentMapping['state'])
            );
        }
        
        return $vars;
    }
    
}
