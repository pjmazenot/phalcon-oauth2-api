<?php

namespace App\Entities\Models;

use App\Entities\Base\Model;

/**
 * Class OAuth2RefreshTokenModel
 *
 * @package App\Entities\Models
 */
abstract class OAuth2RefreshTokenModel extends Model {

    /** @var int BIGINT(20) */
    protected $id;

    /** @var string BIGINT(20) */
    protected $oauth2AccessTokenId;

	/** @var string CHAR(40) */
	protected $refreshToken;

    /** @var string DATETIME */
    protected $expireAt;

    /** @var string DATETIME */
    protected $issuedAt;

	/** @var int */
	protected $isRevoked;

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId( $id ) {
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getOauth2AccessTokenId() {
		return $this->oauth2AccessTokenId;
	}

	/**
	 * @param string $oauth2AccessTokenId
	 */
	public function setOauth2AccessTokenId( $oauth2AccessTokenId ) {
		$this->oauth2AccessTokenId = $oauth2AccessTokenId;
	}

	/**
	 * @return string
	 */
	public function getRefreshToken() {
		return $this->refreshToken;
	}

	/**
	 * @param string $refreshToken
	 */
	public function setRefreshToken( $refreshToken ) {
		$this->refreshToken = $refreshToken;
	}

	/**
	 * @return string
	 */
	public function getExpireAt() {
		return $this->expireAt;
	}

	/**
	 * @param string $expireAt
	 */
	public function setExpireAt( $expireAt ) {
		$this->expireAt = $expireAt;
	}

	/**
	 * @return string
	 */
	public function getIssuedAt() {
		return $this->issuedAt;
	}

	/**
	 * @param string $issuedAt
	 */
	public function setIssuedAt( $issuedAt ) {
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
		return 'oauth2_refresh_token';
	}

}