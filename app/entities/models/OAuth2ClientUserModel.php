<?php

namespace App\Entities\Models;

use App\Entities\Base\Model;

/**
 * Class OAuth2ClientUserModel
 *
 * @package App\Entities\Models
 */
abstract class OAuth2ClientUserModel extends Model {

    /** @var int BIGINT(20) */
    protected $id;

    /** @var int BIGINT(20) */
    protected $oauth2ClientId;

	/** @var int BIGINT(20) */
	protected $oauth2UserId;

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
	public function getOauth2UserId() {
		return $this->oauth2UserId;
	}

	/**
	 * @param int $oauth2UserId
	 */
	public function setOauth2UserId( $oauth2UserId ) {
		$this->oauth2UserId = $oauth2UserId;
	}

	public function getSource()
	{
		return 'oauth2_client_user';
	}

}