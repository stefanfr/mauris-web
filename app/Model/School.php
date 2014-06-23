<?php

class School extends AppModel {

	public $displayField = 'name';

	public $validate = array(
		'name' => array(
			array(
				'rule'    => 'notEmpty',
				'message' => 'Enter a name for the organization'
			)
		),
		'logo' => array(
			array(
				'rule'       => 'url',
				'allowEmpty' => true
			)
		)
	);

        public $hasMany = array(
            'HasDepartments' => array(
                'className' => 'Department',
                'foreignKey' => 'school_id'
            )
	);

    public $belongsTo = array(
        'UsesStyle' => array(
            'className' => 'Style',
            'foreignKey' => 'style_id'
        ),
        'UsesLanguage' => array(
            'className' => 'Language',
            'foreignKey' => 'language_id'
        )
    );

	public function findByHostname($hostname) {
		$key = 'school-' . $hostname;
		$school = Cache::read($key);
		if ($school !== false) {
			return $school;
		}

		$school = $this->find('first', array(
			'conditions' => array(
				$this->alias . '.hostname' => $hostname
			),
			'recursive'  => 0
		));
		Cache::write($key, $school);

		return $school;
	}

	public function getSchoolInfo($id) {
		$cacheKey = 'school-' . $id;

		$department = Cache::read($cacheKey);
		if ($department !== false) {
			return $department;
		}

		$department = $this->read(null, $id);

		Cache::write($cacheKey, $department);

		return $department;
	}

	public function getStyleId($id) {
		$cacheKey = 'school-' . $id . '-style';

		$style = Cache::read($cacheKey);
		if ($style !== false) {
			return $style;
		}

		$style = $this->field('style_id', array(
			$this->alias . '.id' => $id
		));

		Cache::write($cacheKey, $style);

		return $style;
	}

	public function getLanguageId($id) {
		$cacheKey = 'school-' . $id . '-language';

		$style = Cache::read($cacheKey);
		if ($style !== false) {
			return $style;
		}

		$style = $this->field('language_id', array(
			$this->alias . '.id' => $id
		));

		Cache::write($cacheKey, $style);

		return $style;
	}
	
}
