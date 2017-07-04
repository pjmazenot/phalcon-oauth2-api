<?php

namespace App\Entities\Repositories;

use App\Entities\OAuth2AccessToken;
use App\Entities\OAuth2AccessTokenScope;
use App\Entities\OAuth2Session;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

/**
 * Class Oauth2AccessTokenRepository
 *
 * @package App\Entities\Repositories
 */
class Oauth2AccessTokenRepository implements AccessTokenRepositoryInterface {

    /**
     * Create a new access token
     *
     * @param ClientEntityInterface  $clientEntity
     * @param ScopeEntityInterface[] $scopes
     * @param mixed                  $userIdentifier
     *
     * @return AccessTokenEntityInterface
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null) {

        $accessToken = new OAuth2AccessToken();
        $accessToken->setClient($clientEntity);
        $accessToken->setUserIdentifier($userIdentifier);

        foreach ($scopes as $scope) {
            $accessToken->addScope($scope);
        }

        return $accessToken;

    }

    /**
     * Persists a new access token to permanent storage.
     *
     * @param AccessTokenEntityInterface $accessTokenEntity
     * @throws \Exception
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity) {

	    /** @var OAuth2AccessToken $accessTokenEntity */
	    if($accessTokenEntity->getOauth2SessionId() == null) {

		    // Create new session
		    $session = new OAuth2Session();
		    $session->setOauth2ClientId($accessTokenEntity->getClient()->getId());
		    $session->setOauth2UserId($accessTokenEntity->getUserIdentifier());
		    $session->setCreatedAt(date('Y-m-d H:i:s'));
		    if(!$session->save()) {
			    throw new \Exception('Unable to save the session');
		    }

		    $accessTokenEntity->setOauth2SessionId($session->getId());

	    }

        $accessTokenEntity->setIssuedAt(date('Y-m-d H:i:s'));
	    if(!$accessTokenEntity->save()) {
		    throw new \Exception('Unable to save the access token');
	    }

	    $scopes = $accessTokenEntity->getScopes();
	    foreach ($scopes as $scope) {

		    $accessTokenScope = new OAuth2AccessTokenScope();
		    $accessTokenScope->setOauth2AccessTokenId($accessTokenEntity->getId());
		    $accessTokenScope->setOauth2ScopeId($scope->getId());
		    if(!$accessTokenScope->save()) {
			    throw new \Exception('Unable to save the access token scope');
		    }

	    }

    }

    /**
     * Revoke an access token.
     *
     * @param string $tokenId
     * @throws \Exception
     */
    public function revokeAccessToken($tokenId) {

	    /** @var OAuth2AccessToken $accessToken */
	    $accessToken = OAuth2AccessToken::findFirst('accessToken = "' . $tokenId . '"');

	    if($accessToken) {
		    $accessToken->setIsRevoked(true);
		    $accessToken->save();
	    } else {
		    throw new \Exception('Unable to revoke the access token');
	    }

    }

    /**
     * Check if the access token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     * @throws \Exception
     */
    public function isAccessTokenRevoked($tokenId) {

	    /** @var OAuth2AccessToken $accessToken */
	    $accessToken = OAuth2AccessToken::findFirst('accessToken = "' . $tokenId . '"');

	    if(!$accessToken) {
            throw new \Exception('Access token not found: ' . $tokenId);
	    }

	    return empty($accessToken) || $accessToken->getIsRevoked();

    }

}