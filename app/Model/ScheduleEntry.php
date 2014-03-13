
<?php
App::uses('Teacher', 'Model');
App::uses('ClassroomDetails', 'Model');
App::uses('SubjectDetails', 'Model');

class ScheduleEntry extends AppModel {
	
	public $belongsTo = array(
		'GivenToClass' => array(
			'className' => 'AClass',
			'foreignKey' => 'class_id'
		),
		'GivenSubject' => array(
			'className' => 'Subject',
			'foreignKey' => 'subject_id'
		),
		'GivenByTeacher' => array(
			'className' => 'Teacher',
			'foreignKey' => 'teacher_id'
		),
		'GivenInClassroom' => array(
			'className' => 'Classroom',
			'foreignKey' => 'classroom_id'
		),
                'GivenInPeriod' => array(
                    'className' => 'Period',
                    'foreignKey' => 'period'
                ),
                'GivenAtDeparment' => array(
                    'className' => 'Department',
                    'foreignKey' => 'department_id'
                )
	);
	
	public $hasMany = array(
		'GivenAssignments' => array(
			'className' => 'AssignmentScheduleMapping',
			'foreignKey' => 'schedule_entry_id'
		)
	);
	
        public function __construct($id = false, $table = null, $ds = null) {
            parent::__construct($id, $table, $ds);
            
            $this->Teacher = new Teacher();
            $this->ClassroomDetails = new ClassroomDetails();
            $this->SubjectDetails = new SubjectDetails();
        }
        
	public function getWeekScheduleForClass($classId, $startDate, $endDate) {
            $hash = md5(implode('|', array($classId, $startDate, $endDate)));
            $key = 'schedule-class-timed-' . $hash;
            
            /*$data = Cache::read($key);
            if ($data !== false) {
                return $data;
            }*/
            
            $data = $this->find(
			'all',
			array(
				'recursive' => 2,
				'conditions' => array(
                                    'ScheduleEntry.class_id' => $classId,
                                    'ScheduleEntry.date BETWEEN ? AND ?' => array(
                                        $startDate,
                                        $endDate,
                                    ),
				)
			)
            );
            Cache::write($key, $data);
            
            return $data;
	}
        
        public function getSchedule($condition = null) {
            $findConditions = array();
            if (ctype_digit($condition)) {
                $findConditions['ScheduleEntry.id'] = $condition;
            } elseif (is_array($condition)) {
                if (isset($condition['date'])) {
                    $findConditions['ScheduleEntry.date BETWEEN ? AND ?'] = array(
                        $condition['date']['start'],
                        $condition['date']['end'],
                    );
                }
                if (isset($condition['class'])) {
                    $findConditions['ScheduleEntry.class_id'] = $condition['class'];
                }
                if (isset($condition['teacher'])) {
                    $findConditions['ScheduleEntry.teacher_id'] = $condition['teacher'];
                }
                if (isset($condition['classroom'])) {
                    $findConditions['ScheduleEntry.classroom_id'] = $condition['class'];
                }
                if (isset($condition['department'])) {
                    $findConditions['ScheduleEntry.department_id'] = $condition['department'];
                }
                
            }
            if (ctype_digit($this->id)) {
                $findConditions['ScheduleEntry.id'] = $this->id;
            }

            $hash = md5(serialize($findConditions));
            $key = 'schedule-' . $hash;

            Cache::set(array('duration' => '+2 hour'));
            $data = Cache::read($key);
            if ($data !== false) {
                return $data;
            }

            $entries = $this->find(
                'all',
                array(
                    'recursive' => 2,
                    'conditions' => $findConditions
                )
            );
            $subjectDetailIds = array();
            foreach ($entries as $entry) {
                if (!empty($entry['GivenSubject']['MappingInformation']['subject_details_id'])) {
                    $subjectDetailIds[$entry['GivenSubject']['id']] = $entry['GivenSubject']['MappingInformation']['subject_details_id'];
                }
            }
            
            $subjectDetailsRaw = $this->SubjectDetails->getByIds($subjectDetailIds);
            $subjectDetails = array();
            foreach ($subjectDetailsRaw as $details) {
                foreach ($details['MappingInformation'] as $mapping) {
                    $subjectDetails[$mapping['subject_id']] = $details;
                }
            }
            
            $classroomDetailIds = array();
            foreach ($entries as $entry) {
                if (!empty($entry['GivenInClassroom']['MappingInformation']['classroom_details_id'])) {
                    $classroomDetailIds[$entry['GivenInClassroom']['id']] = $entry['GivenInClassroom']['MappingInformation']['classroom_details_id'];
                }
            }
            
            $classroomDetailsRaw = $this->ClassroomDetails->getByIds($classroomDetailIds);
            $classroomDetails = array();
            //print_r($classroomDetailsRaw);
            if (!empty($classroomDetailsRaw)) {
                foreach ($classroomDetailsRaw as $details) {
                    foreach ($details['MappingInformation'] as $mapping) {
                        $classroomDetails[$mapping['classroom_id']] = $details;
                    }
                }
            }
            
            /*$teacherProfileIds = array();
            foreach ($entries as $entry) {
                if (!empty($entry['GivenInClassroom']['MappingInformation']['classroom_details_id'])) {
                    $classroomDetailIds[$entry['GivenInClassroom']['id']] = $entry['GivenInClassroom']['MappingInformation']['classroom_details_id'];
                }
            }*/
            
            foreach ($entries as &$entry) {
                if (isset($subjectDetails[$entry['GivenSubject']['id']])) {
                    $entry['GivenSubject']['SubjectDetails'] = $subjectDetails[$entry['GivenSubject']['id']]['SubjectDetails'];
                }
                if (isset($classroomDetails[$entry['GivenInClassroom']['id']])) {
                    $entry['GivenInClassroom']['ClassroomDetails'] = $classroomDetails[$entry['GivenInClassroom']['id']]['ClassroomDetails'];
                }
            }
            
            Cache::set(array('duration' => '+2 hour'));
            Cache::write($key, $entries);

            return $entries;
        }

}
