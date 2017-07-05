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

	// Setup HMAC Authentication callback to validate user before routing message
	// Failure to validate will stop the process before going to proper Restful Route
	//$app->setEventsManager(new \Classes\Events\HmacAuthenticate());

	// Load routing
	require_once __DIR__ . '/routing.php';

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
