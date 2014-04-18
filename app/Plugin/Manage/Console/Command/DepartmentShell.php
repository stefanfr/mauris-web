<?php

App::uses('AppShell', 'Console/Command');

class DepartmentShell extends AppShell {

	public $uses = array('Department');

	public function index() {
		$departmentsBySchool = $this->Department->find(
			'list',
			array(
				'fields' => array('id', 'name', 'BelongingToSchool.name'),
				'recursive' => 2
			)
		);
		foreach ($departmentsBySchool as $schoolName => $departments) {
			$this->out($schoolName);

			foreach ($departments as $id => $name) {
				$this->out("\t" . $id . "\t" . $name);
			}
			$this->hr();
		}
	}

	public function add() {
		$languages = array_replace(
			array(
				null => 'Default'
			),
			$this->Department->UsesLanguage->find('list')
		);
		$styles = array_replace(
			array(
				null => 'None'
			),
			$this->Department->UsesStyle->find('list')
		);
		$schools = $this->Department->BelongingToSchool->find('list');

		$data = array();

		$this->__printHeader(__('Main information'));

		$data['Department']['name'] = $this->__ask(__('Enter the department name'));
		$data['Department']['school_id'] = array_search(
			$this->__ask(__('Enter the school name:'), null, $schools),
			$schools
		);

		$this->__printHeader(__('Optional information'));

		$data['Department']['hostname'] = $this->__ask('Enter the department hostname:');
		$data['Department']['style_id'] = array_search(
			$this->__ask(__('What style is the department supposed to use?'), array_shift(array_values($styles)), $styles),
			$styles
		);
		$data['Department']['language_id'] = array_search(
			$this->__ask(__('What language is the department supposed to use?'), array_shift(array_values($languages)), $languages),
			$languages
		);

		$this->hr(1);

		$this->Department->create();
		$this->Department->save($data);
		if ($this->Department->id) {
			$this->out('<info>' . __('The department has been created with id %d', $this->Department->id) . '</info>');
		} else {
			$this->error(
				__('Department could not be created'),
				__('Could not create the department')
			);

			$this->_stop(1);
		}
	}

	public function delete() {
		$this->Department->id = (int) $this->args[0];
		$result = $this->Department->delete();
		if ($result) {
			$this->out('<info>' . __('The department with id %d was deleted', (int) $this->args[0]) . '</info>');
		} else {
			$this->error(
				__('Department could not be removed'),
				$this->wrapText(__('Could not delete the department with id %d, possibly because it doesn\'t exist.', (int) $this->args[0]))
			);

			$this->_stop(1);
		}
	}

	public function getOptionParser() {
		$parser = parent::getOptionParser();

		$parser
		->addSubcommand('index', array(
			'help' => __('List the departments'),
		))
		->addSubcommand('add', array(
			'help' => __('Add a departments'),
		))
		->addSubcommand('delete', array(
			'help' => __('Delete a department'),
			'parser' => array(
				'description' => __('Use this command to delete a department from the database.'),
				'arguments' => array(
					'id' => array(
						'help' => __('The id of the department to delete'),
						'required' => true
					)
				)
			)
		));

		return $parser;
	}

	private function __ask($question, $default = null, $options = null) {
		while (!($answer = $this->in($question, $options, $default))) {
			if ($answer == 'Q') {
				return null;
			}
		}

		return $answer;
	}

	private function __printHeader($text) {
		$this->out();
		$this->hr();
		$this->out('<info>' . $text . '</info>');
		$this->hr();
		$this->out();
	}

}