<?php

namespace App\OAuth2\Entities\Repositories;

use App\OAuth2\Entities\OAuth2AccessToken;
use App\OAuth2\Entities\OAuth2Scope;
use Phalcon\Mvc\Model\Resultset\Simple;

/**
 * Class OAuth2AccessTokenScopeRepository
 *
 * @package App\OAuth2\Entities\Repositories
 */
class OAuth2AccessTokenScopeRepository {

    /**
     * Get access token scopes
     *
     * @param OAuth2AccessToken $token
     *
     * @return OAuth2Scope[]
     */
    public function getScopes(OAuth2AccessToken $token) {

        // Get attachments
        // A raw SQL statement
        $sql = 'SELECT s.* 
			FROM oauth2_scope AS s
			JOIN oauth2_access_token_scope AS ats ON ats.oauth2_scope_id = s.id
			WHERE 
				ats.oauth2_access_token_id = ' . $token->getId() . ' 
			ORDER BY s.id DESC';

        // Base model
        $scopeEntity = new OAuth2Scope();

        // Execute the query
        $scopes = new Simple(
            null,
            $scopeEntity,
            $scopeEntity->getReadConnection()->query($sql)
        );

        return $scopes;

    }

}