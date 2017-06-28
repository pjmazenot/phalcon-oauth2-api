<?php

namespace App\Entities;

use App\Entities\Models\OAuth2AccessTokenModel;
use App\Entities\Models\OAuth2RefreshTokenModel;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;

/**
 * Class OAuth2RefreshToken
 *
 * @package App\Entities
 */
class OAuth2RefreshToken extends OAuth2RefreshTokenModel implements RefreshTokenEntityInterface {

    /** @var AccessTokenEntityInterface */
    protected $accessToken;

    /** @var \DateTime */
    protected $expiryDateTime;

    /**
     * Get the token's identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->getRefreshToken();
    }

    /**
     * Set the token's identifier.
     *
     * @param $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->setRefreshToken($identifier);
    }

    /**
     * Get token expiration datetime
     *
     * @return \DateTime
     */
    public function getExpiryDateTime() {

        if(!isset($this->expiryDateTime)) {
            $expiryDateTime = new \DateTime($this->getExpiresAt());
            $this->expiryDateTime = $expiryDateTime;
        }

        return $this->expiryDateTime;

    }

    /**
     * Set token expiration datetime
     *
     * @param \DateTime $dateTime
     */
    public function setExpiryDateTime(\DateTime $dateTime) {

        $this->expiryDateTime = $dateTime;
        $this->setExpiresAt($dateTime->format('Y-m-d H:i:s'));

    }

    /**
     * Set the access token that the refresh token was associated with.
     *
     * @param AccessTokenEntityInterface $accessToken
     */
    public function setAccessToken(AccessTokenEntityInterface $accessToken)
    {

        /** @var AccessToken $accessToken */
        $this->accessToken = $accessToken;
        $this->oauth2AccessTokenId = $accessToken->getId();

    }

    /**
     * Get the access token that the refresh token was originally associated with.
     *
     * @return AccessTokenEntityInterface
     */
    public function getAccessToken()
    {

	    if(!isset($this->accessToken)) {
		    $this->accessToken = OAuth2AccessToken::findFirst('id = ' . $this->getOauth2AccessTokenId());
	    }

        return $this->accessToken;

    }

}