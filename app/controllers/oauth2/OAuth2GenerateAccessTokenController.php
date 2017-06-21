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

	/**
	 * Generate an access token
	 *
	 * @SWG\Post(
	 *     path="/oauth/access_token",
	 *     summary="Generate an access token",
	 *     tags={"oauth2"},
	 *     @SWG\Parameter(
	 *         name="body",
	 *         in="body",
	 *         required=true,
	 *         @SWG\Schema(ref="#/definitions/DocsOAuth2GenerateAccessTokenParameters")
	 *     ),
	 *     @SWG\Response(
	 *         response=200,
	 *         description="Access token generated",
	 *         @SWG\Schema(ref="#/definitions/DocsOAuth2GenerateAccessTokenResponse")
	 *     ),
	 *     @SWG\Response(
	 *         response=422,
	 *         description="Error(s) in auth parameters"
	 *     ),
	 *     @SWG\Response(
	 *         response=500,
	 *         description="Server error"
	 *     )
	 * )
	 */
	public function generateToken() {

	    $this->init();

		/* @var \League\OAuth2\Server\AuthorizationServer $server */
        $server = $this->getDI()->get(SERVICE_OAUTH2_AUTHORIZATION_SERVER);

		try {

			// Try to respond to the request
			$generateResponse = $server->respondToAccessTokenRequest($this->getPsr7Request(), new Psr7Response());

			// Fix empty string result when using getContents()
            $generateResponse->getBody()->rewind();

			// Send the response
            $this->send(200, json_decode($generateResponse->getBody()->getContents(), true));

		} catch (OAuthServerException $e) {

			// All instances of OAuthServerException can be formatted into a HTTP response
			// return $e->generateHttpResponse(new Psr7Response());
			$this->send(500, [
				'message' => $e->getMessage(),
			]);

		} catch (\Exception $e) {

			$this->send(500, [
				'code' => $e->getCode(),
				'message' => $e->getMessage(),
				'trace' => $e->getTraceAsString(),
			]);

		}

	}

}

/**
 * Interface DocsOAuth2GenerateAccessTokenParameters
 *
 * @package App\Controllers\OAuth2
 *
 * @SWG\Definition(
 *     definition="DocsOAuth2GenerateAccessTokenParameters",
 *     @SWG\Property(
 *         property="grant_type",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="client_id",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="client_secret",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="scope",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="redirect_uri",
 *         type="string"
 *     )
 * )
 */
interface DocsOAuth2GenerateAccessTokenParameters {}

/**
 * Interface DocsOAuth2GenerateAccessTokenResponse
 *
 * @package App\Controllers\OAuth2
 *
 * @SWG\Definition(
 *     definition="DocsOAuth2GenerateAccessTokenResponse",
 *     @SWG\Property(
 *         property="token_type",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="expires_in",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="access_token",
 *         type="string"
 *     )
 * )
 */
interface DocsOAuth2GenerateAccessTokenResponse {}
