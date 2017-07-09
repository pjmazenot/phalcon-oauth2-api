<?php

namespace App\OAuth2\Controllers;

use App\Common\Classes\Responses\Psr7Response;
use App\Common\Controllers\DefaultController;
use GuzzleHttp\Psr7\Response as GuzzlePsr7Response;
use League\OAuth2\Server\Exception\OAuthServerException;
use Phalcon\Http\Response;

/**
 * Class OAuth2RefreshTokenController
 *
 * @package App\OAuth2\Controllers
 */
class OAuth2RefreshTokenController extends DefaultController {

	/**
	 * Generate an access token
	 *
	 * @SWG\Post(
	 *     path="/oauth/refresh_token",
	 *     summary="Refresh an access token",
	 *     tags={"oauth2"},
	 *     @SWG\Parameter(
	 *         name="body",
	 *         in="body",
	 *         required=true,
	 *         @SWG\Schema(ref="#/definitions/DocsOAuth2RefreshTokenParameters")
	 *     ),
	 *     @SWG\Response(
	 *         response=200,
	 *         description="Access token generated",
	 *         @SWG\Schema(ref="#/definitions/DocsOAuth2RefreshTokenResponse")
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
	public function refreshToken() {

	    $this->init();

		/* @var \League\OAuth2\Server\AuthorizationServer $server */
        $server = $this->getDI()->get(SERVICE_OAUTH2_AUTHORIZATION_SERVER);

		try {

		    // Init response
            $responseType = $this->getRequest()->get('type');
            if($responseType == 'bearer') {
                $response = new GuzzlePsr7Response();
            } else {
                $response = new Psr7Response();
            }

			// Try to respond to the request
			$generateResponse = $server->respondToAccessTokenRequest($this->getPsr7Request(), $response);

			// Fix empty string result when using getContents()
            $generateResponse->getBody()->rewind();

			// Send the response
            return $this->getResponse(200, json_decode($generateResponse->getBody()->getContents(), true));

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
 * Interface DocsOAuth2RefreshTokenParameters
 *
 * @TODO: Create separated swagger calls for each grant types
 *
 * @package App\Controllers\OAuth2
 *
 * @SWG\Definition(
 *     definition="DocsOAuth2RefreshTokenParameters",
 *     @SWG\Property(
 *         property="grant_type",
 *         description="client_credentials|password",
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
 *     )
 * )
 */
interface DocsOAuth2RefreshTokenParameters {}

/**
 * Interface DocsOAuth2RefreshTokenResponse
 *
 * @package App\Controllers\OAuth2
 *
 * @SWG\Definition(
 *     definition="DocsOAuth2RefreshTokenResponse",
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
interface DocsOAuth2RefreshTokenResponse {}
