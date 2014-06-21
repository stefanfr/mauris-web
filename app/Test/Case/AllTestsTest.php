<?php

class AllTestsTest extends CakeTestSuite {

	public function __construct() {
		parent::__construct('All tests');
	}

	public static function suite() {
		$suite = new AllTestsTest();
		$suite->addTestDirectoryRecursive(TESTS . 'Case');

		return $suite;
	}

}