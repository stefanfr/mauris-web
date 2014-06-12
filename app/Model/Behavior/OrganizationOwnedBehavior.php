<?php

App::uses('ModelBehavior', 'Model/Behavior');

class OrganizationOwnedBehavior extends ModelBehavior {

	public function beforeFind(Model $Model, $querydata) {
		if (isset($querydata['scopes'])) {
			$conditions = array();
			if (in_array('system', $querydata['scopes'])) {
				$subConditions = array();
				if ($Model->hasField('school_id')) {
					$subConditions[] = $Model->alias . '.school_id IS NULL';
				}
				if ($Model->hasField('department_id')) {
					$subConditions[] = $Model->alias . '.department_id IS NULL';
				}

				$conditions['and']['or'][] = array(
					'and' => $subConditions
				);
			}
			if ((in_array('organization', $querydata['scopes'])) || in_array('school', $querydata['scopes'])) {
				$subConditions = array();
				if ($Model->hasField('school_id')) {
					$subConditions[$Model->alias . '.school_id'] = $querydata['organization'];
				}
				if ($Model->hasField('department_id')) {
					$subConditions[] = $Model->alias . '.department_id IS NULL';
				}

				$conditions['and']['or'][] = array(
					'and' => $subConditions
				);
			}
			if (in_array('department', $querydata['scopes'])) {
				$subConditions = array();
				if ($Model->hasField('department_id')) {
					$subConditions[$Model->alias . '.department_id'] = $querydata['department'];
				}

				$conditions['and']['or'][] = array(
					'or' => $subConditions
				);
			}

			$querydata['conditions'][] = $conditions;
		}

		return $querydata;
	}

}