<?php

namespace App\Entities\Models;

use App\Entities\Base\Model;

/**
 * Class OAuth2AccessTokenModel
 *
 * @package App\Entities\Models
 */
abstract class OAuth2AccessTokenModel extends Model {

    /** @var int BIGINT(20) */
    protected $id;

	/** @var int BIGINT(20) */
	protected $oauth2SessionId;

    /** @var string CHAR(40) */
    protected $accessToken;

    /** @var string DATETIME */
    protected $expireAt;

    /** @var string DATETIME */
    protected $issuedAt;

	/** @var int */
	protected $isRevoked;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

	/**
	 * @return int
	 */
	public function getOauth2SessionId() {
		return $this->oauth2SessionId;
	}

	/**
	 * @param int $oauth2SessionId
	 */
	public function setOauth2SessionId( $oauth2SessionId ) {
		$this->oauth2SessionId = $oauth2SessionId;
	}

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getExpireAt()
    {
        return $this->expireAt;
    }

    /**
     * @param string $expireAt
     */
    public function setExpireAt($expireAt)
    {
        $this->expireAt = $expireAt;
    }

    /**
     * @return string
     */
    public function getIssuedAt()
    {
        return $this->issuedAt;
    }

    /**
     * @param string $issuedAt
     */
    public function setIssuedAt($issuedAt)
    {
        $this->issuedAt = $issuedAt;
    }

	/**
	 * @return bool
	 */
	public function getIsRevoked(): bool {
		return (bool)$this->isRevoked;
	}

	/**
	 * @param bool $isRevoked
	 */
	public function setIsRevoked( bool $isRevoked ) {
		$this->isRevoked = (int)$isRevoked;
	}

	public function getSource()
	{
		return 'oauth2_access_token';
	}

}