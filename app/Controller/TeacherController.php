<?php

class TeacherController extends AppController {

    public function view($id) {
        $this->Teacher->id = $id;
        $this->Teacher->recursive = 2;
        
        $teacher = $this->Teacher->read();
        if (!$teacher) {
            throw new NotFoundException(__('Could not find this teacher'));
        }
        
        $this->set(
            'title_for_layout',
            ($teacher['Teacher']['name']) ? $teacher['Teacher']['name'] : $teacher['Teacher']['abbreviation']
        );
        $this->set('teacher', $teacher);
    }
    
}