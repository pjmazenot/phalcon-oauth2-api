<?php

namespace App\OAuth2\Entities\Models;

use App\Common\Classes\Entities\Model;

/**
 * Class OAuth2ClientGrantTypeModel
 *
 * @package App\OAuth2\Entities\Models
 */
abstract class OAuth2ClientGrantTypeModel extends Model {

    /** @var int BIGINT(20) */
    protected $id;

    /** @var int BIGINT(20) */
    protected $oauth2ClientId;

    /** @var int BIGINT(20) */
    protected $oauth2GrantTypeId;

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
	public function getOauth2GrantTypeId() {
		return $this->oauth2GrantTypeId;
	}

	/**
	 * @param int $oauth2GrantTypeId
	 */
	public function setOauth2GrantTypeId( $oauth2GrantTypeId ) {
		$this->oauth2GrantTypeId = $oauth2GrantTypeId;
	}

	public function getSource()
	{
		return 'oauth2_client_grant_type';
	}

}