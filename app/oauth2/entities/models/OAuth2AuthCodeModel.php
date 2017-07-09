<?php

namespace App\OAuth2\Entities\Models;

use App\Common\Classes\Entities\Model;

/**
 * Class OAuth2AuthCodeModel
 *
 * @package App\OAuth2\Entities\Models
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
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
	public function setOauth2SessionId($oauth2SessionId ) {
		$this->oauth2SessionId = $oauth2SessionId;
	}

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @param string $redirectUri
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
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
	public function getIsRevoked() {
		return (bool)$this->isRevoked;
	}

	/**
	 * @param bool $isRevoked
	 */
	public function setIsRevoked($isRevoked ) {
		$this->isRevoked = (int)$isRevoked;
	}

	public function getSource()
	{
		return 'oauth2_auth_code';
	}

}