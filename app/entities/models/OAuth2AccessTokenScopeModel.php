<?php

namespace App\Entities\Models;

use App\Entities\Base\Model;

/**
 * Class OAuth2AccessTokenScopeModel
 *
 * @package App\Entities\Models
 */
abstract class OAuth2AccessTokenScopeModel extends Model {

    /** @var int BIGINT(20) */
    protected $id;

    /** @var int BIGINT(20) */
    protected $oauth2AccessTokenId;

    /** @var int BIGINT(20) */
    protected $oauth2ScopeId;

	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId( int $id ) {
		$this->id = $id;
	}

	/**
	 * @return int
	 */
	public function getOauth2AccessTokenId(): int {
		return $this->oauth2AccessTokenId;
	}

	/**
	 * @param int $oauth2AccessTokenId
	 */
	public function setOauth2AccessTokenId( int $oauth2AccessTokenId ) {
		$this->oauth2AccessTokenId = $oauth2AccessTokenId;
	}

	/**
	 * @return int
	 */
	public function getOauth2ScopeId(): int {
		return $this->oauth2ScopeId;
	}

	/**
	 * @param int $oauth2ScopeId
	 */
	public function setOauth2ScopeId( int $oauth2ScopeId ) {
		$this->oauth2ScopeId = $oauth2ScopeId;
	}

	public function getSource()
	{
		return 'oauth2_access_token_scope';
	}

}