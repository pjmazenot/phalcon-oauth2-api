<?php

namespace App\OAuth2\Entities;

use App\OAuth2\Entities\Models\OAuth2AccessTokenModel;
use App\OAuth2\Entities\Repositories\OAuth2AccessTokenScopeRepository;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;

/**
 * Class OAuth2AccessToken
 *
 * @package App\OAuth2\Entities
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
    public function getIdentifier()
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
    public function getExpiryDateTime() {

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
     * Get scopes
     *
     * @return OAuth2Scope[]
     */
    public function getScopes() {

        if(!isset($this->scopes)) {

            $accessTokenScopeRepository = new OAuth2AccessTokenScopeRepository();
            $this->scopes = $accessTokenScopeRepository->getScopes($this);

        }

        return $this->scopes;

    }

}