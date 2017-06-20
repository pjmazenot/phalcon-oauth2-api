<?php

namespace App\Entities\Repositories;

use App\Entities\OAuth2Scope;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use Phalcon\Mvc\Model\Resultset\Simple;

class OAuth2ClientScopeRepository {

	/**
	 * Get client scopes
	 *
	 * @param ClientEntityInterface $client
	 *
	 * @return OAuth2Scope[]
	 */
	public function getScopes(ClientEntityInterface $client) {

			// Get attachments
			// A raw SQL statement
			$sql = 'SELECT s.* 
			FROM oauth2_scope AS s
			JOIN oauth2_client_scope AS cs ON cs.oauth2_scope_id = s.id
			WHERE 
				cs.oauth2_client_id = ' . $client->getIdentifier() . ' 
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