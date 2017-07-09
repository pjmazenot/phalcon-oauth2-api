<?php

namespace App\OAuth2\Entities\Models;

use App\Common\Classes\Entities\Model;

/**
 * Class OAuth2AccessTokenModel
 *
 * @package App\OAuth2\Entities\Models
 *
 * @SWG\Definition(
 *     required={"id"}
 * )
 */
abstract class OAuth2AccessTokenModel extends Model {

    /**
     * @var int $id BIGINT(20)
     * @SWG\Property(type="integer", format="int64")
     */
    protected $id;

	/**
	 * @var int $oauth2SessionId BIGINT(20)
	 * @SWG\Property(type="integer", format="int64")
	 */
	protected $oauth2SessionId;

    /**
     * @var string $accessToken VARCHAR(100)
     * @SWG\Property(type="string")
     */
    protected $accessToken;

    /**
     * @var string $expireAt DATETIME
     * @SWG\Property(type="string", format="date-time")
     */
    protected $expireAt;

    /**
     * @var string $issuedAt DATETIME
     * @SWG\Property(type="string", format="date-time")
     */
    protected $issuedAt;

	/**
	 * @var int $isRevoked TINYINT(1)
	 * @SWG\Property(type="boolean")
	 */
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
	public function setOauth2SessionId( $oauth2SessionId ) {
		$this->oauth2SessionId = $oauth2SessionId;
	}

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
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
		return $this->isRevoked;
	}

	/**
	 * @param bool $isRevoked
	 */
	public function setIsRevoked($isRevoked) {
		$this->isRevoked = $isRevoked;
	}

	public function getSource()
	{
		return 'oauth2_access_token';
	}

}