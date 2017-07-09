<?php

namespace App\OAuth2\Entities\Models;

use App\Common\Classes\Entities\Model;

/**
 * Class OAuth2ScopeModel
 *
 * @package App\OAuth2\Entities\Models
 */
abstract class OAuth2ScopeModel extends Model {

    /** @var int SMALLINT(5) */
    protected $id;

    /** @var string VARCHAR(40) */
    protected $scope;

    /** @var string VARCHAR(255) */
    protected $name;

    /** @var string VARCHAR(255) */
    protected $description;

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
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param string $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string|null $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

	public function getSource()
	{
		return 'oauth2_scope';
	}

}