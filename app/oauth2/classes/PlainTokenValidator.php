<?php

namespace App\OAuth2\Classes;

use App\OAuth2\Entities\OAuth2AccessToken;
use League\OAuth2\Server\AuthorizationValidators\AuthorizationValidatorInterface;
use League\OAuth2\Server\CryptTrait;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use Phalcon\Exception;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class PlainTokenValidator
 *
 * @package App\OAuth2\Classes
 */
class PlainTokenValidator implements AuthorizationValidatorInterface
{
    use CryptTrait;

    /**
     * @var AccessTokenRepositoryInterface
     */
    private $accessTokenRepository;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @param AccessTokenRepositoryInterface $accessTokenRepository
     */
    public function __construct(AccessTokenRepositoryInterface $accessTokenRepository, $accessToken)
    {
        $this->accessTokenRepository = $accessTokenRepository;
        $this->accessToken = $accessToken;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthorization(ServerRequestInterface $request)
    {

        try {

            // Check if token has been revoked
            if ($this->accessTokenRepository->isAccessTokenRevoked($this->accessToken)) {
                throw OAuthServerException::accessDenied('Access token has been revoked');
            }

            /** @var OAuth2AccessToken $oauth2AccessToken */
            $oauth2AccessToken = OAuth2AccessToken::findFirst('accessToken = "' . $this->accessToken . '"');
            $nowDateTime = new \DateTime();

            if($nowDateTime > $oauth2AccessToken->getExpiryDateTime()) {
                throw OAuthServerException::accessDenied('Access token is expired');
            }

            // Get session from token
            $session = $oauth2AccessToken->getSession();

            // Get token scopes
            $scopes = [];
            foreach ($oauth2AccessToken->getScopes() as $scope) {
                $scopes[] = $scope->getScope();
            }

            // Return the request with additional attributes
            return $request
                ->withAttribute('oauth_access_token_id', $oauth2AccessToken->getIdentifier())
                ->withAttribute('oauth_client_id', $session->getOauth2ClientId())
                ->withAttribute('oauth_user_id', $session->getOauth2UserId())
                ->withAttribute('oauth_scopes', implode(' ', $scopes));

        } catch (Exception $e) {
            throw OAuthServerException::accessDenied($e->getMessage());
        }

    }

}
