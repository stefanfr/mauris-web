<?php

class ContributionsController extends WebsiteAppController {
	
	public $repo = 'MMS-Projects/mauris-web';
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		$this->Auth->allow(array('contribute', 'info'));
	}
	
	public function index() {
		$this->set('contributers', $this->_getContributers());
	}

	private function _getContributers() {
		$contributors = array();

		if (!function_exists('curl_init')) {
			$this->log(
				'Could not get the contributors list of GitHub because cURL isn\'t installed', LOG_WARNING, 'website'
			);

			return false;
		}

		// create a new cURL resource
		$ch = curl_init();

		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/repos/' . $this->repo . '/stats/contributors');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mauris Systems');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// grab URL and pass it to the browser
		$json = json_decode(curl_exec($ch));
		foreach ($json as $jsonContributor) {
			$contributor = array();
			$contributor['contributions'] = $jsonContributor->total;
			$contributor['username'] = $jsonContributor->author->login;
			$contributor['gravatar_id'] = $jsonContributor->author->gravatar_id;
			$contributor['profile'] = $jsonContributor->author->html_url;
			$contributor['source'] = 'github';

			$contributors[] = $contributor;
		}

		usort($contributors, function ($a, $b) {
			if ($a['contributions'] == $b['contributions']) {
				return 0;
			}

			return ($a['contributions'] < $b['contributions']) ? 1 : 0;
		});

		return $contributors;
	}
	
	public function contribute() {

	}

	public function info($type) {
		$viewPath = array($this->viewPath, 'types', $type);

		try {
			$this->render(implode(DS, $viewPath));
		} catch (MissingViewException $exception) {
			if (Configure::read('debug')) {
				throw $exception;
			}
			throw new NotFoundException();
		}
	}
	
}
