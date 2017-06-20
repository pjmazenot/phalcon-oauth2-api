<?php

namespace App\Entities\Models;

use App\Entities\Base\Model;

/**
 * Class OAuth2AuthCodeScopeModel
 *
 * @package App\Entities\Models
 */
abstract class OAuth2AuthCodeScopeModel extends Model {

    /** @var int BIGINT(20) */
    protected $id;

    /** @var int BIGINT(20) */
    protected $oauth2AuthCodeId;

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
	public function getOauth2AuthCodeId(): int {
		return $this->oauth2AuthCodeId;
	}

	/**
	 * @param int $oauth2AuthCodeId
	 */
	public function setOauth2AuthCodeId( int $oauth2AuthCodeId ) {
		$this->oauth2AuthCodeId = $oauth2AuthCodeId;
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
		return 'oauth2_auth_code_scope';
	}

}