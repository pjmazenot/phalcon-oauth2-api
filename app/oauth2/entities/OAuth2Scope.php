<?php

namespace App\OAuth2\Entities;

use App\OAuth2\Entities\Models\OAuth2ScopeModel;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

/**
 * Class OAuth2Scope
 *
 * @package App\OAuth2\Entities
 */
class OAuth2Scope extends OAuth2ScopeModel implements ScopeEntityInterface {

    /**
     * Get the scope's identifier.
     *
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->getScope();
    }

}