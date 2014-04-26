<?php

class OrganizationSelector {

	protected $_organization;
	protected $_department;
	protected $_location;

	public function __toString() {
		return implode('.', array(
			$this->_organization,
			$this->_department,
			$this->_location
		));
	}

	public function setOrganization($id) {
		$this->_organization = $id;
	}

	public function unsetOrganization() {
		$this->_organization = null;
	}

	public function hasOrganization() {
		return (bool) $this->_organization;
	}

	public function getOrganization() {
		return $this->_organization;
	}

	public function setDepartment($id) {
		$this->_department = $id;
	}

	public function unsetDepartment() {
		$this->_department = null;
	}

	public function hasDepartment() {
		return (bool) $this->_department;
	}

	public function getDepartment() {
		return $this->_department;
	}

	public function setLocation($id) {
		$this->_location = $id;
	}

	public function unsetLocation() {
		$this->_location = null;
	}

	public function hasLocation() {
		return (bool) $this->_location;
	}

	public function getLocation() {
		return $this->_location;
	}

}
