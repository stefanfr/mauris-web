<?php

App::uses('ModelBehaviour', 'Model/ModelBehavior');
App::uses('OrganizationSelector', 'Lib');

class OrganizationOwnedBehavior extends ModelBehavior {

	public function beforeFind(\Model $Model, $query) {
		if (isset($query['match'])) {
			/**
			 * @var \OrganizationSelector
			 */
			$OrganizationSelector = $query['match'];

			$matchConditions = array();
			$matchConditions['or'][] = array(
				'and' => array(
					$Model->name . '.school_id IS NULL',
					$Model->name . '.department_id IS NULL'
				)
			);
			if ($OrganizationSelector->hasOrganization()) {
				$matchConditions['or'][] = array(
					'and' => array(
						$Model->name . '.school_id' => $OrganizationSelector->getOrganization(),
						$Model->name . '.department_id IS NULL'
					)
				);
			}
			if ($OrganizationSelector->hasDepartment()) {
				$matchConditions['or'][] = array(
					'and' => array(
						$Model->name . '.department_id' => $OrganizationSelector->getDepartment(),
						//$Model->name . '.department_id' =
					)
				);
			}

			$query['conditions'][] = $matchConditions;
		}

		return $query;
	}

	public function scope(Model $Model, \OrganizationSelector $Selector, $id = null) {
		if ($Model->id) {
			$id = $Model->id;
		}
		$post = $Model->find('first', array(
			'conditions' => array(
				$Model->name . '.id' => $id
			),
			'recursive'  => -1
		));

		$scope = 'system';

		if ($Selector->hasOrganization()) {
			if ($post['Post']['school_id'] == $Selector->getOrganization()) {
				$scope = 'school';
			}
		}
		if ($Selector->hasDepartment()) {
			if ($post['Post']['department_id'] == $Selector->getDepartment()) {
				$scope = 'department';
			}
		}

		return $scope;
	}

}