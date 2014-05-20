<?php

App::uses('FormHelper', 'View/Helper');

/**
 * Class ModelFormHelper
 *
 * @property FormHelper Form
 */
class ModelFormHelper extends FormHelper {

	public $helpers = array(
		'Form'
	);

	public function create($model = null, $options = array()) {
		$options = array_merge($options, array(
			'inputDefaults' => array(
				'div'       => 'form-group',
				'label'     => array(
					'class' => 'col col-md-3 control-label'
				),
				'wrapInput' => 'col col-md-9',
				'class'     => 'form-control'
			),
			'class'         => 'form-horizontal'
		));

		return $this->Form->create($model, $options);
	}

}