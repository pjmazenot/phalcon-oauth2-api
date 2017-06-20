<?php

namespace App\Entities\Models;

use App\Entities\Base\Model;

/**
 * Class OAuth2ClientScopeModel
 *
 * @package App\Entities\Models
 */
abstract class OAuth2ClientScopeModel extends Model {

    /** @var int BIGINT(20) */
    protected $id;

    /** @var int BIGINT(20) */
    protected $oauth2ClientId;

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
	public function setId( $id ) {
		$this->id = $id;
	}

	/**
	 * @return int
	 */
	public function getOauth2ClientId() {
		return $this->oauth2ClientId;
	}

	/**
	 * @param int $oauth2ClientId
	 */
	public function setOauth2ClientId( $oauth2ClientId ) {
		$this->oauth2ClientId = $oauth2ClientId;
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
	public function setOauth2ScopeId( $oauth2ScopeId ) {
		$this->oauth2ScopeId = $oauth2ScopeId;
	}

	public function getSource()
	{
		return 'oauth2_client_scope';
	}

}