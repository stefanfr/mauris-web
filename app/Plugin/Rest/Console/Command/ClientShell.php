<?php

App::uses('AppShell', 'Console/Command');

class ClientShell extends AppShell {

	public function main() {
		$url = $this->args[0];

		$route = Router::parse($url) + array('[method]' => $this->params['method']);
		$route['ext'] = 'json';

		$this->out(array('<comment>Route:</comment>', print_r($route, true)), 1, Shell::VERBOSE);

		$response = $this->requestAction($route, array(
			'return'
		));

		$data = json_decode($response);
		if (is_null($data)) {
			$this->error(__('Could not decode the response'), __('The response is not valid JSON. Is the RequestHandler being used?'));
		}

		$this->out(array('<comment>Data:</comment>' , json_encode($data, JSON_PRETTY_PRINT)), 1, Shell::QUIET);
	}

	public function getOptionParser() {
		$parser = parent::getOptionParser();
		$parser->description(array(
			'Does a request to a internal url to test REST behaviour.',
			'<info>Note:</info> The extension will always be JSON'
		))
			->addArgument('url', array(
				'help'     => __('The URL to request.'),
				'required' => true
			))
			->addOption('method', array(
				'default' => 'GET',
				'help'    => __('HTTP method to use'),
				'short'   => 'm',
				'choices' => array(
					'GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'OPTIONS', 'DELETE'
				)
			));

		return $parser;
	}

}
