<?php

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessToken;

/**
 * Class ExampleOAuth2Client
 * Class example of an OAuth2 client
 */
class ExampleOAuth2Client {

	/** @var GenericProvider $provider */
	public $provider;

	/** @var string $grantType */
	public $grantType;

	/** @var string $authParams */
	public $authParams;

	/** @var AccessToken */
	public $accessToken;

	/**
	 * ExampleOAuth2Client constructor
	 *
	 * @param string $clientId
	 * @param string $clientSecret
	 * @param string $grantType
	 * @param array $authParams
	 */
	public function __construct($clientId, $clientSecret, $grantType, $authParams = []) {

		// Note: the GenericProvider requires the `urlAuthorize` option, even though
		// it's not used in the OAuth 2.0 client credentials grant type.
		$this->provider = new \League\OAuth2\Client\Provider\GenericProvider([
			'clientId'                => $clientId,
			'clientSecret'            => $clientSecret,
			'redirectUri'             => 'http://' . $_SERVER['SERVER_NAME'] . '/',
			'urlAuthorize'            => 'http://' . $_SERVER['SERVER_NAME'] . '/oauth/authorize',
			'urlAccessToken'          => 'http://' . $_SERVER['SERVER_NAME'] . '/oauth/access_token',
			'urlResourceOwnerDetails' => 'http://' . $_SERVER['SERVER_NAME'] . '/resource'
		]);

		$this->grantType = $grantType;
		$this->authParams = $authParams;

	}

	/**
	 * Get provider
	 *
	 * @return GenericProvider
	 * @throws Exception
	 */
	public function getProvider() {

		if(!isset($this->provider)) {
			throw new Exception('No provider available');
		}

		return $this->provider;

	}

	/**
	 * Get access token
	 *
	 * @return AccessToken
	 * @throws Exception
	 */
	public function getAccessToken() {

		if(isset($this->accessToken)) {

			return $this->accessToken;

		} else {

			$cacheToken = $this->getCachedToken();

			if(!$cacheToken) {

				try {

					// Try to get an access token using the client credentials grant.
					$this->accessToken = $this->getProvider()->getAccessToken($this->grantType, $this->authParams);

					$this->setCachedToken($this->accessToken);

					return $this->accessToken;

				} catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

					// Failed to get the access token
					throw $e;

				}

			} else {

				$this->accessToken = $cacheToken;

				return $this->accessToken;

			}

		}

	}

	/**
	 * Get the cached access token
	 *
	 * @return bool|string
	 */
	public function getCachedToken() {

		// Create your own caching function
		return false;

	}

	/**
	 * Get the cached access token
	 *
	 * @param string $accessToken
	 */
	public function setCachedToken($accessToken) {

		// Create your own caching function

	}

	/**
	 * Send an authenticated request
	 *
	 * @param string $method
	 * @param string $url
	 * @param array $params
	 *
	 * @return array
	 * @throws Exception
	 */
	public function request($method, $url, $params = []) {

		try {

			// The provider provides a way to get an authenticated API request for
			// the service, using the access token; it returns an object conforming
			// to Psr\Http\Message\RequestInterface.
			$request = $this->getProvider()->getAuthenticatedRequest(
				$method,
				$url,
				$this->getAccessToken(),
				$params
			);

			$response = $this->getProvider()->getResponse($request);
			$result = json_decode($response->getBody()->getContents(), true);

			if(!empty($result)) {
				return $result;
			} else {
				$response->getBody()->rewind();
				echo $response->getBody()->getContents();
				return [];
			}

		} catch (\GuzzleHttp\Exception\ClientException $e) {

			throw $e;

		} catch (\GuzzleHttp\Exception\ServerException $e) {

			throw $e;

		} catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

			// Failed to get the access token or user details.
			throw $e;

		}

	}

}