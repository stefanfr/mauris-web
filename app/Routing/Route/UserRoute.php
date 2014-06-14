<?php

App::uses('CakeRoute', 'Routing/Route');
App::uses('ClassRegistry', 'Utility');

class UserRoute extends CakeRoute {

	public function parse($url) {
		// Use the CakePHP core to parse the URL.
		$parsed = parent::parse($url);

		// Get the User model.
		$User = ClassRegistry::init('User');

		// Get the ID for the user identified by the username.
		$id = $User->field('id', array(
			'username' => $parsed['username']
		));

		// If there is no user, it doesn't match.
		if (!$id) {
			return false;
		}

		// Get rid of the username.
		unset($parsed['username']);

		// Set the ID as the first passed parameter.
		array_unshift($parsed['pass'], $id);

		// Return the parsed URL with the ID in it.
		return $parsed;
	}

	public function match($url) {
		// Skip if not matching UsersController::show().
		if (
			$url['controller'] != 'users' ||
			$url['action'] != 'profile'
		) {
			return false;
		}

		// Skip if ID is missing or wrong.
		$pattern = '/^' . Router::ID . '$/';
		if (
			empty($url[0]) ||
			!preg_match($pattern, $url[0])
		) {
			return false;
		}

		// Get the User model.
		$User = ClassRegistry::init('User');

		// Translate the ID into a username.
		$username = $User->field('username', array(
			'id' => $url[0]
		));

		// If there is no username or user, skip again.
		if (!$username) {
			return false;
		}

		// Merge the username with the rest of the parameters.
		$url = array_merge($url, array(
			'username' => $username
		));

		// Unset the ID so it won't end up in the URL.
		unset($url[0]);

		// Use the core routing to make a proper URL.
		return parent::match($url);
	}

}