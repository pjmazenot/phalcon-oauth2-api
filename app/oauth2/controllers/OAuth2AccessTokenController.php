<?php

namespace App\OAuth2\Controllers;

use App\Common\Controllers\DefaultController;
use GuzzleHttp\Psr7\Response as GuzzlePsr7Response;
use League\OAuth2\Server\Exception\OAuthServerException;
use Phalcon\Http\Response;

/**
 * Class OAuth2AccessTokenController
 *
 * @package App\OAuth2\Controllers
 */
class OAuth2AccessTokenController extends DefaultController {

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
	 *         @SWG\Schema(ref="#/definitions/DocsOAuth2AccessTokenParameters")
	 *     ),
	 *     @SWG\Response(
	 *         response=200,
	 *         description="Access token generated",
	 *         @SWG\Schema(ref="#/definitions/DocsOAuth2AccessTokenResponse")
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
     *
     * @return Response
	 */
	public function generateToken() {

	    $this->init();

		/* @var \League\OAuth2\Server\AuthorizationServer $server */
        $server = $this->getDI()->get(SERVICE_OAUTH2_AUTHORIZATION_SERVER);

		try {

			// Try to respond to the request
			$generateResponse = $server->respondToAccessTokenRequest($this->getPsr7Request(), new GuzzlePsr7Response());

			// Fix empty string result when using getContents()
            $generateResponse->getBody()->rewind();

			// Send the response
            return $this->getResponse(200, array_merge(json_decode($generateResponse->getBody()->getContents(), true)));

		} catch (OAuthServerException $e) {

			// All instances of OAuthServerException can be formatted into a HTTP response
			// return $e->generateHttpResponse(new Psr7Response());
			return $this->getResponse(500, [
				'error' => $e->getMessage(),
				'message' => $e->getMessage(),
			]);

		} catch (\Exception $e) {

			return $this->getResponse(500, [
				'code' => $e->getCode(),
				'error' => $e->getMessage(),
				'message' => $e->getMessage(),
				'trace' => $e->getTraceAsString(),
			]);

		}

	}

}

/**
 * Interface DocsOAuth2AccessTokenParameters
 *
 * @TODO: Create separated swagger calls for each grant types
 *
 * @package App\Controllers\OAuth2
 *
 * @SWG\Definition(
 *     definition="DocsOAuth2AccessTokenParameters",
 *     @SWG\Property(
 *         property="grant_type",
 *         description="client_credentials|password|refresh_token",
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
 *         property="username",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="password",
 *         type="password"
 *     ),
 *     @SWG\Property(
 *         property="redirect_uri",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="type",
 *         description="plain(default)|bearer",
 *         type="string"
 *     )
 * )
 */
interface DocsOAuth2AccessTokenParameters {}

/**
 * Interface DocsOAuth2AccessTokenResponse
 *
 * @package App\Controllers\OAuth2
 *
 * @SWG\Definition(
 *     definition="DocsOAuth2AccessTokenResponse",
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
 *     ),
 *     @SWG\Property(
 *         property="refresh_token",
 *         type="string"
 *     )
 * )
 */
interface DocsOAuth2AccessTokenResponse {}
