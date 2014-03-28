<?php
class ScheduleController extends AppController {

    public $components = array(
        'RequestHandler', 'TimeAware', 'SchoolInformation', 'ThemeAware',
        'LanguageAware',
        'DataFilter' => array(
            'custom' => array(
                'class', 'classroom', 'teacher', 'cancelled', 'view'
            )
        )
    );
    public $uses = array('ScheduleEntry', 'SubjectDetails');

    public function index() {
        $this->RequestHandler->setContent('ics', 'text/calendar');
        
        $conditions = array();
        if ($this->DataFilter->hasCustomFilter('cancelled')) {
            $conditions['ScheduleEntry.cancelled'] = $this->DataFilter->getCustomFilter('cancelled');
        }
        $conditions['ScheduleEntry.date BETWEEN ? AND ?'] = array(
            date('Y-m-d', $this->TimeAware->getStart()),
            date('Y-m-d', $this->TimeAware->getEnd())
        );
        $conditions['ScheduleEntry.department_id'] = $this->SchoolInformation->getDepartmentId();
        if ($this->DataFilter->hasCustomFilter('class')) {
            $conditions['ScheduleEntry.class_id'] = $this->DataFilter->getCustomFilter('class');
        }
        if ($this->DataFilter->hasCustomFilter('teacher')) {
            $conditions['ScheduleEntry.teacher_id'] = $this->DataFilter->getCustomFilter('teacher');
        }
        if ($this->DataFilter->hasCustomFilter('classroom')) {
            $conditions['ScheduleEntry.classroom_id'] = $this->DataFilter->getCustomFilter('classroom');
        }
        $entries = $this->ScheduleEntry->find(
            'all',
            array(
                'recursive' => 2,
                'conditions' => $conditions
            )
        );
        
        if ($this->DataFilter->hasCustomFilter('view')) {
            $this->view = $this->DataFilter->getCustomFilter('view');
        }
        
        $this->set(array(
            'entries' => $entries,
            '_serialize' => array('entries')
        ));
    }

    public function view() {
        $timezone = new DateTimeZone('Europe/Amsterdam');

        //var_dump($this->ScheduleEntry->getData(array('class' => 1)));
        //var_dump($this->request->query);
        $conditions = array(
             'date' => array(
                'start' => date('Y-m-d', $this->TimeAware->getStart()),
                'end'   => date('Y-m-d', $this->TimeAware->getEnd())
            )
        );
        $conditions['department'] = $this->SchoolInformation->getDepartmentId();
        if ($this->DataFilter->hasCustomFilter('class')) {
            $conditions['class'] = $this->DataFilter->getCustomFilter('class');
        }
        if ($this->DataFilter->hasCustomFilter('teacher')) {
            $conditions['teacher'] = $this->DataFilter->getCustomFilter('teacher');
        }
        if ($this->DataFilter->hasCustomFilter('classroom')) {
            $conditions['classroom'] = $this->DataFilter->getCustomFilter('classroom');
        }
        $entries = $this->ScheduleEntry->getSchedule($conditions);
        /*$scheduleEntries = $this->ScheduleEntry->getWeekScheduleForClass(
            $this->request->query['aClass'], , 
        );
        $subjectDetailIds = array();
        foreach ($scheduleEntries as $scheduleEntry) {
            if (!empty($scheduleEntry['GivenSubject']['MappingInformation']['subject_details_id'])) {
                $subjectDetailIds[$scheduleEntry['GivenSubject']['id']] = $scheduleEntry['GivenSubject']['MappingInformation']['subject_details_id'];
            }
        }
        
        //print_r($subjectDetailIds);
        
        $subjectDetailsRaw = $this->SubjectDetails->getByIds($subjectDetailIds);
        $subjectDetails = array();
        foreach ($subjectDetailsRaw as $details) {
            foreach ($details['MappingInformation'] as $mapping) {
                $subjectDetails[$mapping['subject_id']] = $details;
            }
        }
        
        //print_r($subjectDetails);*/
        
        //print_r($entries);
        
        
        
        $calendarEvents = array();
        foreach ($entries as $entry) {
            $startDate = new DateTime($entry['ScheduleEntry']['date'] . ' ' . $entry['GivenInPeriod']['start']);
            $endDate = new DateTime($entry['ScheduleEntry']['date'] . ' ' . $entry['GivenInPeriod']['end']);

            $startDate->setTimezone($timezone);
            $endDate->setTimezone($timezone);

            $event = array(
                'id' => $entry['ScheduleEntry']['id'],
                'url' => Router::url(array(
                    'controller' => 'schedule',
                    'action' => 'view',
                    $entry['ScheduleEntry']['id']
                )),
                'title' => (isset($entry['GivenSubject']['SubjectDetails'])) ? $entry['GivenSubject']['SubjectDetails']['title'] : $entry['GivenSubject']['abbreviation'],
                'start' => $startDate->format('c'),
                'end' => $endDate->format('c'),
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
            );
            
            $event['assignments'] = array();
            foreach ($entry['GivenAssignments'] as $assignmentMapping) {
                $assignment = $assignmentMapping['Assignment'];
                $event['assignments'][] = array(
                    'id' => $assignment['id'],
                    'title' => $assignment['title'],
                    'description' => $assignment['description'],
                    'state' => explode(',', $assignmentMapping['state'])
                );
            }
            
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
            
            
            
            $calendarEvents[] = $event;
        }
        
        //$recipe = $this->Recipe->findById($id);
        $this->set(array(
            'events' => $calendarEvents,
            '_serialize' => array('events')
        ));
    }
    
}
