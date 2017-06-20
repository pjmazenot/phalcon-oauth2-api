<?php

namespace App\Controllers\OAuth2;

use App\Controllers\DefaultController;
use GuzzleHttp\Psr7\Response as Psr7Response;
use League\OAuth2\Server\Exception\OAuthServerException;

/**
 * Class OAuthGenerateTokenController
 *
 * @package App\Controllers\OAuth2
 */
class OAuth2GenerateAccessTokenController extends DefaultController {

	public function generateToken() {

	    $this->init();

		/* @var \League\OAuth2\Server\AuthorizationServer $server */
        $server = $this->getDI()::getDefault()->get(SERVICE_OAUTH2_AUTHORIZATION_SERVER);

		try {

			// Authorization code
			// Try to respond to the request
			$generateResponse = $server->respondToAccessTokenRequest($this->getPsr7Request(), new Psr7Response());

			// Fix empty string result when using getContents()
            $generateResponse->getBody()->rewind();

            // @TODO: Check format
            $this->send(200, json_decode($generateResponse->getBody()->getContents(), true));

		} catch (OAuthServerException $exception) {

			// All instances of OAuthServerException can be formatted into a HTTP response
            echo $exception->getMessage();die;
			return $exception->generateHttpResponse(new Psr7Response());

		} catch (\Exception $e) {
		    echo $e->getMessage();die;

			$this->send(500, [
				'message' => $e->getTraceAsString()
			]);
		}

	}

}
