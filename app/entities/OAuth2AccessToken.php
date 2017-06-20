<?php

namespace App\Entities;

use App\Entities\Models\OAuth2AccessTokenModel;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;

/**
 * Class OAuth2AccessToken
 *
 * @package App\Entities
 */
class OAuth2AccessToken extends OAuth2AccessTokenModel implements AccessTokenEntityInterface {

    use AccessTokenTrait;

	/** @var int */
    protected $oauth2UserId;

    /** @var OAuth2Session */
    protected $session;

    /** @var OAuth2Client */
    protected $client;

    /** @var \DateTime */
    protected $expiryDatetime;

    /** @var OAuth2AccessTokenScope[] */
    protected $scopes = [];

    /**
     * Get the token's identifier.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->getAccessToken();
    }

    /**
     * et the token's identifier.
     *
     * @param $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->setAccessToken($identifier);
    }

    /**
     * Get token expiration datetime
     *
     * @return \DateTime
     */
    public function getExpiryDateTime(): \DateTime {

        if(!isset($this->expiryDatetime)) {
            $expiryDateTime       = new \DateTime($this->getExpireAt());
            $this->expiryDatetime = $expiryDateTime;
        }

        return $this->expiryDatetime;

    }

    /**
     * Set token expiration datetime
     *
     * @param \DateTime $dateTime
     */
    public function setExpiryDateTime(\DateTime $dateTime) {

        $this->expiryDatetime = $dateTime;
        $this->setExpireAt($dateTime->format('Y-m-d H:i:s'));

    }

    /**
     * Get the token user's identifier.
     *
     * @return OAuth2Session
     */
    public function getSession() {

	    if(!isset($this->session) && isset($this->oauth2SessionId)) {
		    $this->session = OAuth2Session::findFirst('id = ' . $this->getOauth2SessionId());
	    }

        return $this->session;

    }

    /**
     * Get the token user's identifier.
     *
     * @return string|int
     */
    public function getUserIdentifier() {

	    if(!isset($this->oauth2UserId) && isset($this->oauth2SessionId)) {
		    $this->oauth2UserId = $this->getSession()->getOauth2UserId();
	    }

        return $this->oauth2UserId;

    }

	/**
	 * Set the identifier of the user associated with the token.
	 *
	 * @param string|int $identifier The identifier of the user
	 */
	public function setUserIdentifier($identifier) {

		$this->oauth2UserId = $identifier;

	}

    /**
     * Get the client that the token was issued to.
     *
     * @return OAuth2Client
     */
    public function getClient() {

        if(!isset($this->client) && isset($this->oauth2SessionId)) {
	        $this->client = OAuth2Client::findFirst('id = ' . $this->getSession()->getOauth2ClientId());
        }

        return $this->client;

    }

    /**
     * Set the client that the token was issued to.
     *
     * @param ClientEntityInterface $client
     */
    public function setClient(ClientEntityInterface $client) {

        $this->client = $client;

    }

    /**
     * Associate a scope with the token.
     *
     * @param ScopeEntityInterface $scope
     */
    public function addScope(ScopeEntityInterface $scope) {

        $this->scopes[] = $scope;

    }

    /**
     * Return an array of scopes associated with the token.
     *
     * @return OAuth2AccessTokenScope[]
     */
    public function getScopes() {

        return $this->scopes;

    }

}