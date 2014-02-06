<?php
class Subject extends AppModel {
	
	public $displayField = 'abbreviation';

	public $hasMany = array(
		/*'ScheduleEntry' => array(
			'className' => 'ScheduleEntry',
			'foreignKey' => 'subject_id'
		),*/
		'SubjectDetailsMapping' => array(
			'className' => 'SubjectDetailsMapping',
			'foreignKey' => 'subject_id'
		)
	);

	protected function _readDataSource($type, $query) {
		$cacheName = md5(json_encode($query));
		$cache = Cache::read($cacheName, 'cache-config-name');
		var_dump($cache, $cacheName);
		if ($cache !== false) {
			return $cache;
		}

		$results = parent::_readDataSource($type, $query);
		Cache::write($cacheName, $results, 'cache-config-name');
		return $results;
	}

}
