<?php

namespace App\OAuth2\Entities\Models;

use App\Common\Classes\Entities\Model;

/**
 * Class OAuth2UserModel
 *
 * @package App\OAuth2\Entities\Models
 */
abstract class OAuth2UserModel extends Model {

    /** @var int BIGINT(20) */
    protected $id;

    /** @var string VARCHAR(150)*/
    protected $username;

    /** @var string CHAR(128)*/
    protected $password;

    /** @var string DATETIME */
    protected $createdAt;

    /** @var string DATETIME */
    protected $updatedAt;

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
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
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
		return 'oauth2_user';
	}

}