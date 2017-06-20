<?php

namespace App\Entities\Repositories;

use App\Entities\OAuth2GrantType;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use Phalcon\Mvc\Model\Resultset\Simple;

class Oauth2ClientGrantTypeRepository {

	/**
	 * Get client grant types
	 *
	 * @param ClientEntityInterface $client
	 *
	 * @return OAuth2GrantType[]
	 */
	public function getGrantTypes(ClientEntityInterface $client) {

		// Get attachments
		// A raw SQL statement
		$sql = 'SELECT gt.*
		FROM oauth2_grant_type AS gt
		JOIN oauth2_client_grant_type AS cgt ON cgt.oauth2_grant_type_id = gt.id
		WHERE 
			cgt.oauth2_client_id = ' . $client->getIdentifier() . ' 
		ORDER BY gt.id DESC';

		// Base model
        $grantTypeEntity = new OAuth2GrantType();

		// Execute the query
		/** @var OAuth2GrantType[] $grantTypes */
		$grantTypes = new Simple(
			null,
            $grantTypeEntity,
            $grantTypeEntity->getReadConnection()->query($sql)
		);

		return $grantTypes;

	}

}