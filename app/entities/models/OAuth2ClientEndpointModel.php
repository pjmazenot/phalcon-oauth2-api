<?php

namespace App\Entities\Models;

use App\Entities\Base\Model;

/**
 * Class OAuth2ClientEndpointModel
 *
 * @package App\Entities\Models
 */
abstract class OAuth2ClientEndpointModel extends Model {

    /** @var int BIGINT(20) */
    protected $id;

    /** @var int BIGINT(20) */
    protected $oauth2ClientId;

    /** @var string VARCHAR(255) */
    protected $redirectUri;

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
	 * @return string
	 */
	public function getRedirectUri() {
		return $this->redirectUri;
	}

	/**
	 * @param string $redirectUri
	 */
	public function setRedirectUri( $redirectUri ) {
		$this->redirectUri = $redirectUri;
	}

	public function getSource()
	{
		return 'oauth2_client_endpoint';
	}

}