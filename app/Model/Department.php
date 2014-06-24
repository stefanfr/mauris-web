<?php

App::uses('AppModel', 'Model');

class Department extends AppModel {
	
    public $displayField = 'name';

    public $belongsTo = array(
        'BelongingToSchool' => array(
            'className' => 'School',
            'foreignKey' => 'school_id'
        ),
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
        $key = 'department-' . $hostname; 
        $department = Cache::read($key);
        if ($department !== false) {
            return $department;
        }
        
        $department = $this->find('first', array(
            'conditions' => array(
                $this->alias . '.hostname' => $hostname
            ),
	        'recursive'  => 0
        ));
        Cache::write($key, $department);
        
        return $department;
    }

	public function getDepartmentInfo($id) {
		$cacheKey = 'department-' . $id;

		$department = Cache::read($cacheKey);
		if ($department !== false) {
			return $department;
		}

		$department = $this->read(null, $id);

		Cache::write($cacheKey, $department);

		return $department;
	}

	public function getStyleId($id) {
		$cacheKey = 'department-' . $id . '-style';

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

	public function getLanguageCode($id) {
		$cacheKey = 'department-' . $id . '-language';

		$languageCode = Cache::read($cacheKey);
		if ($languageCode !== false) {
			return $languageCode;
		}

		$languageId = $this->field('language_id', array(
			$this->alias . '.id' => $id
		));

		if ($languageId !== null) {
			$languageCode = $this->UsesLanguage->getCode($languageId);
		} else {
			$languageCode = null;
		}if ($languageId !== null) {
			$languageCode = $this->UsesLanguage->getCode($languageId);
		} else {
			$languageCode = null;
		}

		Cache::write($cacheKey, $languageCode);

		return $languageCode;
	}

}
