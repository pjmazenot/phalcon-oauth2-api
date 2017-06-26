<?php

// Load vendors
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/vendor/autoload.php';

// Load client libs
require_once 'includes/ExampleOAuth2Client.php';

// Retrieve post data
$post_data = $_POST;

// Init response data array
$response = [];

try {

	// Process requests based on the grant type
	$grant_type = isset($post_data['grant_type']) ? $post_data['grant_type'] : '';
	switch ($grant_type) {

		case 'client_credentials':

			// Retrieve request params
			$scope         = isset( $post_data['scope'] ) ? $post_data['scope'] : '';
			$client_id     = isset( $post_data['client_id'] ) ? $post_data['client_id'] : '';
			$client_secret = isset( $post_data['client_secret'] ) ? $post_data['client_secret'] : '';

			// Instantiate the OAuth2 client and generate an access token
			$exampleOauth2Client = new ExampleOAuth2Client($client_id, $client_secret);
			$access_token = $exampleOauth2Client->getAccessToken();

			// Add the token to the response data
			$response['status']  = 'success';
			$response['bearer'] = $access_token;

			try {

				// Test authentication using the API test url
				$test = $exampleOauth2Client->request('get', 'http://' . $_SERVER['SERVER_NAME'] . '/oauth/test');

				// Add the authentication results to the response data
				$response['api_test'] = [
					'status' => 'success',
					'message' => $test
				];

			} catch (Exception $e) {

				// Add the authentication error to the response data
				$response['api_test'] = [
					'status' => 'failed',
					'message' => $e->getMessage()
				];

			}

			break;

		default:
			$response['status']  = 'failed';
			$response['message'] = 'Grant type not supported by the example';
			break;

	}

} catch (Exception $e) {

	// Add the error info to the response data
	$response['status']  = 'error';
	$response['message'] = $e->getMessage();
	$response['debug'] = [
		'code' => $e->getCode(),
		'file' => $e->getFile(),
		'line' => $e->getLine(),
		'trace' => $e->getTrace(),
	];

}

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
die;