<?php

class TeacherAbsenceController extends ManageAppController {
    
    public $components = array('Paginator');
    
    public $uses = array('TeacherAbsenceReport', 'UserTeacherMapping', 'Teacher');
    
    public $paginate = array(
        'limit' => 5,
        'order' => array(
            'TeacherAbsenceReport.date' => 'DESC'
        )
    );
    
    public function index() {
        if ($this->Auth->user()) {
            $requester = 'user::' . $this->Auth->user('id');
        } else {
            $requester = 'role::anonymous';
        }
        
        $readAccessScopes = $this->Acl->check(
            $requester, array('permission' => 'teacher-absence', 'school_id' => $this->School->id, 'department_id' => $this->Department->id), 'read'
        );
        if (!$readAccessScopes) {
            throw new ForbiddenException();
        }
        
        $this->Paginator->settings = $this->paginate;
        
        $conditions = array();
        if (in_array('department', $readAccessScopes)) {
            $conditions['and']['or'][] = array(
                'and' => array(
                    'TeacherAbsenceReport.department_id' => $this->Department->id,
                )
            );
        }
        /*if ((in_array('own', $allowedScopes)) && ($this->Auth->user())) {
            $conditions['and']['or'][] = array(
                'and' => array(
                    'Post.user_id' => $this->Auth->user('id'),
                    'Post.school_id' => $this->School->id,
                    array(
                        'or' => array(
                            'Post.department_id' => $this->Department->id,
                            'Post.department_id IS NULL'
                        )
                    )
                )
            );
        }*/
        
        $this->set(
            'absence_reports',
            $this->Paginator->paginate(
                'TeacherAbsenceReport',
                $conditions
            )
        );
    }
    
    public function add() {
        if ($this->Auth->user()) {
            $requester = 'user::' . $this->Auth->user('id');
        } else {
            $requester = 'role::anonymous';
        }
        
        $createAccessScopes = $this->Acl->check(
            $requester, array('permission' => 'teacher-absence', 'school_id' => $this->School->id, 'department_id' => $this->Department->id), 'create'
        );
        if (!$createAccessScopes) {
            throw new ForbiddenException();
        }
        
        $teachers = array();
        if (in_array('department', $createAccessScopes)) {
            $departmentTeachers = $this->Teacher->find(
                'all',
                array(
                    'recursive' => 2,
                    'conditions' => array(
                        'Teacher.department_id' => $this->Department->id
                    )
                )
            );
            
            foreach ($departmentTeachers as $teacher) {
                if (!isset($teachers[$teacher['Teacher']['id']])) {
                    $teachers[$teacher['Teacher']['id']] = $teacher['Teacher'];
                }
            }
        }
        if (in_array('own', $createAccessScopes)) {
            $userTeacherMappings = $this->UserTeacherMapping->find(
                'all',
                array(
                    'recursive' => 2,
                    'conditions' => array(
                        'UserTeacherMapping.user_id' => $this->Auth->user('id'),
                        'Teacher.department_id' => $this->Department->id
                    )
                )
            );
            
            foreach ($userTeacherMappings as $userTeacherMapping) {
                if (!isset($teachers[$userTeacherMapping['Teacher']['id']])) {
                    $teachers[$userTeacherMapping['Teacher']['id']] = $userTeacherMapping['Teacher'];
                }
            }
        }
        
        $this->set('teachers', $teachers);
        
        if ($this->request->is('post')) {
            $this->request->data['TeacherAbsenceReport']['department_id'] = $this->Department->id;
            
            if (!isset($teachers[$this->request->data['TeacherAbsenceReport']['teacher_id']])) {
                throw new ForbiddenException();
            }
            
            $this->TeacherAbsenceReport->create();
            if ($this->TeacherAbsenceReport->save($this->request->data)) {
                $this->Session->setFlash(__('The absence has been reported'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
				
                return $this->redirect(array('action' => 'index'));
            }
            
            $this->Session->setFlash(__('Could not report the absence'), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-danger'
            ));
        }
    }
    
    public function edit($id) {       
        if ($this->Auth->user()) {
            $requester = 'user::' . $this->Auth->user('id');
        } else {
            $requester = 'role::anonymous';
        }
        
        $createAccessScopes = $this->Acl->check(
            $requester, array('permission' => 'teacher-absence', 'school_id' => $this->School->id, 'department_id' => $this->Department->id), 'create'
        );
        if (!$createAccessScopes) {
            throw new ForbiddenException();
        }
        
        if (!$id) {
            throw new NotFoundException(__('The absence report could not be found'));
        }
        
        $this->TeacherAbsenceReport->id = $id;
        if (!$absenceReport = $this->TeacherAbsenceReport->read()) {
            throw new NotFoundException(__('The absence report could not be found'));
        }
        
        if (!$this->request->data) {
            $this->request->data = $absenceReport;
        }
        
        $teachers = array();
        if (in_array('department', $createAccessScopes)) {
            $departmentTeachers = $this->Teacher->find(
                'all',
                array(
                    'recursive' => 2,
                    'conditions' => array(
                        'Teacher.department_id' => $this->Department->id
                    )
                )
            );
            
            foreach ($departmentTeachers as $teacher) {
                if (!isset($teachers[$teacher['Teacher']['id']])) {
                    $teachers[$teacher['Teacher']['id']] = $teacher['Teacher'];
                }
            }
        }
        if (in_array('own', $createAccessScopes)) {
            $userTeacherMappings = $this->UserTeacherMapping->find(
                'all',
                array(
                    'recursive' => 2,
                    'conditions' => array(
                        'UserTeacherMapping.user_id' => $this->Auth->user('id'),
                        'Teacher.department_id' => $this->Department->id
                    )
                )
            );
            
            foreach ($userTeacherMappings as $userTeacherMapping) {
                if (!isset($teachers[$userTeacherMapping['Teacher']['id']])) {
                    $teachers[$userTeacherMapping['Teacher']['id']] = $userTeacherMapping['Teacher'];
                }
            }
        }
        
        $this->set('teachers', $teachers);
        
        $this->TeacherAbsenceReport->id = $id;
        if (!isset($teachers[$this->TeacherAbsenceReport->field('teacher_id')])) {
            throw new ForbiddenException();
        }
        
        if ($this->request->is(array('post', 'put'))) {
            $this->request->data['TeacherAbsenceReport']['department_id'] = $this->Department->id;
            
            if (!isset($teachers[$this->request->data['TeacherAbsenceReport']['teacher_id']])) {
                throw new ForbiddenException();
            }
            
            $this->TeacherAbsenceReport->id = $id;
            if ($this->TeacherAbsenceReport->save($this->request->data)) {
                $this->Session->setFlash(__('The absence report has been changed.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
				
                return $this->redirect(array('action' => 'index'));
            }
            
            $this->Session->setFlash(__('Could not change the absence report'), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-danger'
            ));
        }
    }
    
    public function remove($id) {
        if ($this->Auth->user()) {
            $requester = 'user::' . $this->Auth->user('id');
        } else {
            $requester = 'role::anonymous';
        }
        
        $deleteAccessScopes = $this->Acl->check(
            $requester, array('permission' => 'teacher-absence', 'school_id' => $this->School->id, 'department_id' => $this->Department->id), 'delete'
        );
        if (!$deleteAccessScopes) {
            throw new ForbiddenException();
        }
        
        $teachers = array();
        if (in_array('department', $deleteAccessScopes)) {
            $departmentTeachers = $this->Teacher->find(
                'all',
                array(
                    'recursive' => 2,
                    'conditions' => array(
                        'Teacher.department_id' => $this->Department->id
                    )
                )
            );
            
            foreach ($departmentTeachers as $teacher) {
                if (!isset($teachers[$teacher['Teacher']['id']])) {
                    $teachers[$teacher['Teacher']['id']] = $teacher['Teacher'];
                }
            }
        }
        if (in_array('own', $deleteAccessScopes)) {
            $userTeacherMappings = $this->UserTeacherMapping->find(
                'all',
                array(
                    'recursive' => 2,
                    'conditions' => array(
                        'UserTeacherMapping.user_id' => $this->Auth->user('id'),
                        'Teacher.department_id' => $this->Department->id
                    )
                )
            );
            
            foreach ($userTeacherMappings as $userTeacherMapping) {
                if (!isset($teachers[$userTeacherMapping['Teacher']['id']])) {
                    $teachers[$userTeacherMapping['Teacher']['id']] = $userTeacherMapping['Teacher'];
                }
            }
        }
        
        $this->TeacherAbsenceReport->id = $id;
        if (!isset($teachers[$this->TeacherAbsenceReport->field('teacher_id')])) {
            throw new ForbiddenException();
        }
        
        $this->set('id', $id);
        
        if ($this->request->is('post')) {
            if ($this->TeacherAbsenceReport->delete($id)) {
                    $this->Session->setFlash(__('The absence report has been removed'), 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-success'
                    ));

                    return $this->redirect(array('action' => 'index'));
            }
        }
    }
    
}