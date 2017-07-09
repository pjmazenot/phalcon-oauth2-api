<?php

require_once __DIR__ . '/constants.php';

require_once PATH_VENDOR . '/autoload.php';

// Activate debug for local development (Comment in production)
if(isset($_GET['debug'])) {
	$listener = new \Phalcon\Debug();
	$listener->listen(true, true);
}

/** @var \Phalcon\Loader $loader */
require_once PATH_CONFIGURATION . '/loader.php';

try {

	// The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
	$di = new Phalcon\Di\FactoryDefault();

	// Load services in the DI
	require_once PATH_CONFIGURATION . '/services/service-config.php';
	require_once PATH_CONFIGURATION . '/services/service-databases.php';
	require_once PATH_CONFIGURATION . '/services/service-log.php';
	require_once PATH_CONFIGURATION . '/services/service-oauth2-authorization-server.php';
	require_once PATH_CONFIGURATION . '/services/service-oauth2-resource-server.php';

	// Create the app
	$app = new Phalcon\Mvc\Micro();
	$app->setDI($di);

	// Load routing
	require_once __DIR__ . '/routing.php';

	$app->before(function () use ($app, $settings) {

		// @TODO: Change to custom or add a type in config

		try {

			$rateLimiter = new \App\Services\RateLimit\RateLimitMiddlewareCustom(
				$app->request,
				$app->response,
				filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ? $_SERVER['REMOTE_ADDR'] : 'unknown', //@ TODO Create a lib to get client IP
				$settings['oauth2']['rate_limit']['default']['rules']
			);
			$rateLimiter->checkLimit();

		} catch (\App\Services\RateLimit\Exceptions\RateLimitException $e) {

			// Handle rate limit exceptions
			$app->response->setContent('Rate limit error: ' . $e->getMessage());
			$app->response->setStatusCode(429, 'Too Many Requests');
            $app->response->send();
			die;

		}

	});

	// Default handler function that runs when no route was matched
	$app->notFound(function () use ($app) {

		if($app->__get('request')->getMethod() == 'OPTIONS') {
			$app->response->setStatusCode(200, 'OK');
			$app->response->setHeader('Access-Control-Allow-Origin', '*');
			$app->response->setHeader('Access-Control-Allow-Headers', 'X-Requested-With');
			$app->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
			$app->response->sendHeaders();
			die;
		}

		$app->response->setStatusCode(404, 'Not Found')->sendHeaders();
		die;

	});

	$app->after(function () {});

	// Process the request
	$app->handle();

} catch (Exception $e) {

	// Handle unhandled exceptions
	$app->response->setContent('Unhandled exception: ' . $e->getMessage());
	$app->response->setStatusCode(500, 'Server error')->send();
	die;

} catch (Error $e) {

	// Handle unhandled exceptions
	$app->response->setContent('Unhandled error: ' . $e->getMessage());
	$app->response->setStatusCode(500, 'Server error')->send();
	die;

}
