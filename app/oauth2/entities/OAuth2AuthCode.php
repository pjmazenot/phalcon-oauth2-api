<?php

namespace App\OAuth2\Entities;

use App\OAuth2\Entities\Models\OAuth2AuthCodeModel;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

/**
 * Class OAuth2AuthCode
 *
 * @package App\OAuth2\Entities
 */
class OAuth2AuthCode extends OAuth2AuthCodeModel implements AuthCodeEntityInterface {

	/** @var int */
	protected $oauth2UserId;

	/** @var OAuth2Session */
	protected $session;

    /** @var OAuth2Client */
    protected $client;

    /** @var \DateTime */
    protected $expiryDatetime;

    /** @var OAuth2Scope[] */
    protected $scopes = [];

    /**
     * Get the code's identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->getCode();
    }

    /**
     * et the code's identifier.
     *
     * @param $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->setCode($identifier);
    }

    /**
     * Get code expiration datetime
     *
     * @return \DateTime
     */
    public function getExpiryDateTime() {

        if(!isset($this->expiryDatetime)) {
            $expiryDateTime = new \DateTime($this->getExpireAt());
            $this->expiryDatetime = $expiryDateTime;
        }

        return $this->expiryDatetime;

    }

    /**
     * Set code expiration datetime
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

		if(!isset($this->session)) {
			$this->session = OAuth2Session::findFirst('id = ' . $this->getOauth2SessionId());
		}

		return $this->session;

	}

	/**
	 * Get the code user's identifier.
	 *
	 * @return string|int
	 */
	public function getUserIdentifier() {

		if(!isset($this->oauth2UserId)) {
			$this->oauth2UserId = $this->getSession()->getOauth2UserId();
		}

		return $this->oauth2UserId;

	}

	/**
	 * Set the identifier of the user associated with the code.
	 *
	 * @param string|int $identifier The identifier of the user
	 */
	public function setUserIdentifier($identifier) {

		$this->oauth2UserId = $identifier;

	}

	/**
	 * Get the client that the code was issued to.
	 *
	 * @return OAuth2Client
	 */
	public function getClient() {

		if(!isset($this->client)) {
			$this->client = OAuth2Client::findFirst('id = ' . $this->getSession()->getOauth2ClientId());
		}

		return $this->client;

	}

	/**
	 * Set the client that the code was issued to.
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
     * @return OAuth2Scope[]
     */
    public function getScopes() {

        return $this->scopes;

    }

}