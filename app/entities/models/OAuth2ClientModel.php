<?php

namespace App\Entities\Models;

use App\Entities\Base\Model;

/**
 * Class OAuth2ClientModel
 *
 * @package App\Entities\Models
 */
abstract class OAuth2ClientModel extends Model {

    /** @var string BIGINT(20) PRIMARY KEY*/
    protected $id;

    /** @var string BIGINT(20) */
    protected $clientSecret;

    /** @var string */
    protected $name;

    /** @var int */
    protected $mustValidateSecret;

    /** @var string DATETIME */
    protected $createdAt;

    /** @var string DATETIME */
    protected $updatedAt;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

	/**
	 * @return bool
	 */
	public function getMustValidateSecret(): bool {
		return (bool)$this->mustValidateSecret;
	}

	/**
	 * @param bool $mustValidateSecret
	 */
	public function setMustValidateSecret( bool $mustValidateSecret ) {
		$this->mustValidateSecret = (int)$mustValidateSecret;
	}

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

	public function getSource()
	{
		return 'oauth2_client';
	}

}