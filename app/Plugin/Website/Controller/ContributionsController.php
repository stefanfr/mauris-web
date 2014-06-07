<?php

/**
 * Class ContributionsController
 *
 * @property RepositoryContributor RepositoryContributor
 */
class ContributionsController extends WebsiteAppController {
	
	public $repo = 'MMS-Projects/mauris-web';

	public $uses = array('GitHub.RepositoryContributor');

	public $components = array('Paginator');
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		$this->Auth->allow(array('contribute', 'info'));
	}
	
	public function index() {
		$this->set('contributers', $this->_getContributers());
	}

	private function _getContributers() {
		$this->RepositoryContributor->setDataSource('maurisWebRepository');

		$contributors = array();

		if (!function_exists('curl_init')) {
			$this->log(
				'Could not get the contributors list of GitHub because cURL isn\'t installed', LOG_WARNING, 'website'
			);

			return false;
		}

		$this->Paginator->settings = array(
			$this->RepositoryContributor->alias => array(
				'order' => array(
					'RepositoryContributor.contributions' => 'ASC'
				),
				'limit' => 5
			)
		);

		$gitHubContributors = $this->Paginator->paginate('RepositoryContributor');

		foreach ($gitHubContributors as $gitHubContributor) {
			$contributor = array();
			$contributor['contributions'] = $gitHubContributor['RepositoryContributor']['contributions'];
			$contributor['username'] = $gitHubContributor['RepositoryContributor']['login'];
			$contributor['gravatar_id'] = $gitHubContributor['RepositoryContributor']['gravatar_id'];
			$contributor['profile'] = $gitHubContributor['RepositoryContributor']['html_url'];
			$contributor['source'] = 'github';

			$contributors[] = $contributor;
		}

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
