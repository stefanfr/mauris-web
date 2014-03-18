<?php

class EventController extends AppController {

    public $components = array('RequestHandler', 'TimeAware');
    public $uses = array('Event');

    public function index() {
        $timezone = new DateTimeZone('Europe/Amsterdam');
        
        $schoolId = (int) $this->request->query['school'];
        $departmentId = (int) $this->request->query['department'];
        
        $conditions = array();
        $conditions = array(
            'or' => array(
                array (
                    'Event.start BETWEEN ? AND ?' => array(
                        date('Y-m-d', $this->TimeAware->getStart()),
                        date('Y-m-d', $this->TimeAware->getEnd())
                    )
                ),
                array(
                    'Event.end BETWEEN ? AND ?' => array(
                        date('Y-m-d', $this->TimeAware->getStart()),
                        date('Y-m-d', $this->TimeAware->getEnd())
                    )
                )
            )
        );
        $conditions['and']['or'][] = array(
            'and' => array(
                'Event.school_id IS NULL',
                'Event.department_id IS NULL'
            )
        );
        if ($schoolId) {
            $conditions['and']['or'][] = array(
                'and' => array(
                    'Event.school_id' => $schoolId,
                    'Event.department_id IS NULL'
                )
            );
        }
        if ($departmentId) {
            $conditions['and']['or'][] = array(
                'and' => array(
                    'Event.school_id' => $schoolId,
                    'Event.department_id' => $departmentId
                )
            );
        }
        
        
        
        //debug($conditions);
        
        $events = $this->Event->find(
            'all',
            array(
                'conditions' => $conditions
            )
        );
        
        $calendarEvents = array();
        foreach ($events as $entry) {
            $startDate = new DateTime($entry['Event']['start']);
            $endDate = new DateTime($entry['Event']['end']);

            $startDate->setTimezone($timezone);
            $endDate->setTimezone($timezone);

            $event = array(
                'id' => $entry['Event']['id'],
                'title' => $entry['Event']['title'],
                'description' => $entry['Event']['description'],
                'start' => $startDate->format('c'),
                'end' => $endDate->format('c'),
                'allDay' => (bool) $entry['Event']['all_day'],
                'type' => $entry['Event']['type'],
            );
            
            $calendarEvents[] = $event;
        }
        
        $this->set(array(
            'events' => $calendarEvents,
            '_serialize' => array('events')
        ));
    }

    public function view() {
        $timezone = new DateTimeZone('Europe/Amsterdam');

        //var_dump($this->ScheduleEntry->getData(array('class' => 1)));
        //var_dump($this->request->query);
        $conditions = array(
             'date' => array(
                'start' => date('Y-m-d', $this->request->query['start']),
                'end'   => date('Y-m-d', $this->request->query['end'])
            )
        );
        $conditions['department'] = $this->request->query['department'];
        if (isset($this->request->query['class'])) {
            $conditions['class'] = $this->request->query['class'];
        }
        if (isset($this->request->query['teacher'])) {
            $conditions['teacher'] = $this->request->query['teacher'];
        }
        if (isset($this->request->query['classroom'])) {
            $conditions['classroom'] = $this->request->query['classroom'];
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
        
        $calendarEvent = array();
        $calendarEvent['title'] = 'Voorjaarsvakantie';
        $calendarEvent['start'] = '2014-03-03';
        $calendarEvent['end'] = '2014-03-07';
        $calendarEvents[] = $calendarEvent;
        
        //$recipe = $this->Recipe->findById($id);
        $this->set(array(
            'events' => $calendarEvents,
            '_serialize' => array('events')
        ));
    }
    
}
