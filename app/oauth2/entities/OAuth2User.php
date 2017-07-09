<?php

namespace App\OAuth2\Entities;

use App\OAuth2\Entities\Models\OAuth2UserModel;
use League\OAuth2\Server\Entities\UserEntityInterface;

/**
 * Class OAuth2User
 *
 * @package App\OAuth2\Entities
 */
class OAuth2User extends OAuth2UserModel implements UserEntityInterface {

    /**
     * Get the user's identifier.
     *
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->getId();
    }

}