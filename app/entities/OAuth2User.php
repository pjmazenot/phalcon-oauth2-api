<?php

namespace App\Entities;

use App\Entities\Models\OAuth2UserModel;
use League\OAuth2\Server\Entities\UserEntityInterface;

/**
 * Class OAuth2User
 *
 * @package App\Entities
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