<?php
class AbsentTeacherController extends AppController {

    public $components = array('RequestHandler', 'SchoolInformation', 'TimeAware', 'ThemeAware', 'LanguageAware');
    public $uses = array('TeacherAbsenceReport');

    public function index() {
        $conditions = array();
        if ($this->SchoolInformation->isDepartmentIdAvailable()) {
            $conditions['TeacherAbsenceReport.department_id'] = $this->SchoolInformation->isDepartmentIdAvailable();
        }
        $conditions['TeacherAbsenceReport.date BETWEEN ? AND ?'] = array(
            date('Y-m-d', $this->TimeAware->getStart()),
            date('Y-m-d', $this->TimeAware->getEnd())
        );
        $reports = $this->TeacherAbsenceReport->find(
            'all',
            array(
                'recursive' => 2,
                'conditions' => $conditions
            )
        );
        $this->set(array(
            'reports' => $reports,
            '_serialize' => array('reports')
        ));
    }

}
