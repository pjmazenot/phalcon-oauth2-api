<?php

namespace App\Entities\Models;

use App\Entities\Base\Model;

/**
 * Class OAuth2GrantTypeModel
 *
 * @package App\Entities\Models
 */
abstract class OAuth2GrantTypeModel extends Model {

    /** @var int BIGINT(20) */
    protected $id;

    /** @var string VARCHAR(20) */
    protected $grantType;

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
	public function getGrantType() {
		return $this->grantType;
	}

	/**
	 * @param string $grantType
	 */
	public function setGrantType( $grantType ) {
		$this->grantType = $grantType;
	}

	public function getSource()
	{
		return 'oauth2_grant_type';
	}

}