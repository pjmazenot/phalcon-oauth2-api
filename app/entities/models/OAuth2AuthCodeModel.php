<?php

namespace App\Entities\Models;

use App\Entities\Base\Model;

/**
 * Class OAuth2AuthCodeModel
 *
 * @package App\Entities\Models
 */
abstract class OAuth2AuthCodeModel extends Model {

    /** @var int BIGINT(20) */
    protected $id;

	/** @var int BIGINT(20) */
	protected $oauth2SessionId;

    /** @var string CHAR(40)*/
    protected $code;

    /** @var string VARCHAR(255) */
    protected $redirectUri;

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
	public function getOauth2SessionId(): int {
		return $this->oauth2SessionId;
	}

	/**
	 * @param int $oauth2SessionId
	 */
	public function setOauth2SessionId( int $oauth2SessionId ) {
		$this->oauth2SessionId = $oauth2SessionId;
	}

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getRedirectUri(): string
    {
        return $this->redirectUri;
    }

    /**
     * @param string $redirectUri
     */
    public function setRedirectUri(string $redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    /**
     * @return string
     */
    public function getExpireAt(): string
    {
        return $this->expireAt;
    }

    /**
     * @param string $expireAt
     */
    public function setExpireAt(string $expireAt)
    {
        $this->expireAt = $expireAt;
    }

    /**
     * @return string
     */
    public function getIssuedAt(): string
    {
        return $this->issuedAt;
    }

    /**
     * @param string $issuedAt
     */
    public function setIssuedAt(string $issuedAt)
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
		return 'oauth2_auth_code';
	}

}