<?php

namespace App\OAuth2\Entities\Models;

use App\Common\Classes\Entities\Model;

/**
 * Class OAuth2AccessTokenScopeModel
 *
 * @package App\OAuth2\Entities\Models
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
	public function getId() {
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @return int
	 */
	public function getOauth2AccessTokenId() {
		return $this->oauth2AccessTokenId;
	}

	/**
	 * @param int $oauth2AccessTokenId
	 */
	public function setOauth2AccessTokenId($oauth2AccessTokenId ) {
		$this->oauth2AccessTokenId = $oauth2AccessTokenId;
	}

	/**
	 * @return int
	 */
	public function getOauth2ScopeId() {
		return $this->oauth2ScopeId;
	}

	/**
	 * @param int $oauth2ScopeId
	 */
	public function setOauth2ScopeId($oauth2ScopeId ) {
		$this->oauth2ScopeId = $oauth2ScopeId;
	}

	public function getSource()
	{
		return 'oauth2_access_token_scope';
	}

}