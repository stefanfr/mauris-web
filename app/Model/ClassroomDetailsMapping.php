<?php
class ClassroomDetailsMapping extends AppModel {

	public $belongsTo = array(
		'ClassroomDetails' => array(
			'className' => 'ClassroomDetails',
			'foreignKey' => 'classroom_details_id'
		),
		'Classroom' => array(
			'className' => 'Classroom',
			'foreignKey' => 'classroom_id'
		)
	);
}

