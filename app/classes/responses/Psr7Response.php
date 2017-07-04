<?php

namespace App\Classes\Responses;

use App\Entities\OAuth2AccessToken;
use App\Entities\OAuth2RefreshToken;
use GuzzleHttp\Psr7\Response as GuzzlePsr7Response;
use League\OAuth2\Server\CryptTrait;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Psr7Response
 *
 * @package App\Classes\Responses
 */
class Psr7Response extends GuzzlePsr7Response implements ResponseTypeInterface {

    use CryptTrait;

    /** @var OAuth2AccessToken $accessToken */
    protected $accessToken;

    /** @var OAuth2RefreshToken $refreshToken */
    protected $refreshToken;

    public function getAccessToken() {

        return $this->accessToken;

    }

    /**
     * @param AccessTokenEntityInterface $accessToken
     */
    public function setAccessToken(AccessTokenEntityInterface $accessToken) {

        $this->accessToken = $accessToken;

    }

    public function getRefreshToken() {

        return $this->refreshToken;

    }

    /**
     * @param RefreshTokenEntityInterface $refreshToken
     */
    public function setRefreshToken(RefreshTokenEntityInterface $refreshToken) {

        $this->refreshToken = $refreshToken;

    }

    /**
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function generateHttpResponse(ResponseInterface $response) {

        $expireDateTime = $this->accessToken->getExpiryDateTime()->getTimestamp();

        $responseParams = [
            'token_type'   => 'Plain',
            'expires_in'   => $expireDateTime - (new \DateTime())->getTimestamp(),
            'access_token' => (string) $this->accessToken->getIdentifier(),
        ];

        if ($this->refreshToken instanceof RefreshTokenEntityInterface) {

            $responseParams['refresh_token'] = (string)$this->refreshToken->getIdentifier();

        }

        $response = $response
            ->withStatus(200)
            ->withHeader('pragma', 'no-cache')
            ->withHeader('cache-control', 'no-store')
            ->withHeader('content-type', 'application/json; charset=UTF-8');

        $response->getBody()->write(json_encode($responseParams));

        return $response;

    }

}