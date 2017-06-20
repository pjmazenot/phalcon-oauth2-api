<?php

namespace App\Entities;

use App\Entities\Models\OAuth2ScopeModel;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

/**
 * Class OAuth2Scope
 *
 * @package App\Entities
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