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
            $type          = isset( $post_data['type'] ) ? $post_data['type'] : '';
			$scope         = isset( $post_data['scope'] ) ? $post_data['scope'] : '';
			$client_id     = isset( $post_data['client_id'] ) ? $post_data['client_id'] : '';
			$client_secret = isset( $post_data['client_secret'] ) ? $post_data['client_secret'] : '';

			// Instantiate the OAuth2 client and generate an access token
			$exampleOauth2Client = new ExampleOAuth2Client(
			    $client_id,
                $client_secret,
                'client_credentials',
                [
                    'type' => $type,
                ]
            );
			$token = $exampleOauth2Client->getAccessToken();

			// Add the token to the response data
			$response['status']  = 'success';
			$response['token'] = $token;

			try {

                // Test authentication using the API test url
                if($type == 'bearer') {
                    $test = $exampleOauth2Client->request('get', 'http://' . $_SERVER['SERVER_NAME'] . '/oauth/test');
                } else {
                    $test = $exampleOauth2Client->request('get', 'http://' . $_SERVER['SERVER_NAME'] . '/oauth/test?access_token=' . $token->getToken());
                }

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

		case 'password':

			// Retrieve request params
			$type          = isset( $post_data['type'] ) ? $post_data['type'] : '';
			$scope         = isset( $post_data['scope'] ) ? $post_data['scope'] : '';
			$client_id     = isset( $post_data['client_id'] ) ? $post_data['client_id'] : '';
			$client_secret = isset( $post_data['client_secret'] ) ? $post_data['client_secret'] : '';
			$username      = isset( $post_data['username'] ) ? $post_data['username'] : '';
			$password      = isset( $post_data['password'] ) ? $post_data['password'] : '';

			// Instantiate the OAuth2 client and generate an access token
			$exampleOauth2Client = new ExampleOAuth2Client(
			    $client_id,
                $client_secret,
                'password',
                [
                    'type' => $type,
                    'username' => $username,
                    'password' => $password,
                ]
            );
			$token = $exampleOauth2Client->getAccessToken();

			// Add the token to the response data
			$response['status']  = 'success';
			$response['token'] = $token;

			try {

				// Test authentication using the API test url
                if($type == 'bearer') {
                    $test = $exampleOauth2Client->request('get', 'http://' . $_SERVER['SERVER_NAME'] . '/oauth/test');
                } else {
                    $test = $exampleOauth2Client->request('get', 'http://' . $_SERVER['SERVER_NAME'] . '/oauth/test?access_token=' . $token->getToken());
                }

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

        case 'refresh_token':

            // Retrieve request params
            $type          = isset( $post_data['type'] ) ? $post_data['type'] : '';
            $scope         = isset( $post_data['scope'] ) ? $post_data['scope'] : '';
            $client_id     = isset( $post_data['client_id'] ) ? $post_data['client_id'] : '';
            $client_secret = isset( $post_data['client_secret'] ) ? $post_data['client_secret'] : '';
            $refresh_token = isset( $post_data['refresh_token'] ) ? $post_data['refresh_token'] : '';

            // Instantiate the OAuth2 client and generate an access token
            $exampleOauth2Client = new ExampleOAuth2Client(
                $client_id,
                $client_secret,
                'refresh_token',
                [
                    'type' => $type,
                    'refresh_token' => $refresh_token,
                ]
            );
            $token = $exampleOauth2Client->refreshAccessToken($type);

            // Add the token to the response data
            $response['status']  = 'success';
            $response['token'] = $token;

            try {

                // Test authentication using the API test url
                if($type == 'bearer') {
                    $test = $exampleOauth2Client->request('get', 'http://' . $_SERVER['SERVER_NAME'] . '/oauth/test');
                } else {
                    $test = $exampleOauth2Client->request('get', 'http://' . $_SERVER['SERVER_NAME'] . '/oauth/test?access_token=' . $token->getToken());
                }

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