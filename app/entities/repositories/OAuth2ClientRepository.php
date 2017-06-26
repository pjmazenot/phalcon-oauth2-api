<?php

namespace App\Entities\Repositories;

use App\Entities\OAuth2Client;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

class Oauth2ClientRepository implements ClientRepositoryInterface {

	/**
	 * Get a client.
	 *
	 * @param string      $clientIdentifier   The client's identifier
	 * @param string      $grantType          The grant type used
	 * @param null|string $clientSecret       The client's secret (if sent)
	 * @param bool        $mustValidateSecret If true the client must attempt to validate the secret if the client
	 *                                        is confidential
	 *
	 * @return ClientEntityInterface
	 * @throws \Exception
	 */
	public function getClientEntity($clientIdentifier, $grantType, $clientSecret = null, $mustValidateSecret = true) {

		/** @var OAuth2Client $client */
		$client = OAuth2Client::findFirst('id = "' . $clientIdentifier . '"');

		if(!$client) {
			throw new \Exception('Invalid client ID');
		}

		$clientGrantTypes = $client->getGrantTypes();
		$isGrantTypeValid = false;
		foreach ($clientGrantTypes as $clientGrantType) {
			if($clientGrantType->getGrantType() === $grantType) {
				$isGrantTypeValid = true;
			}
		}

		if(!$isGrantTypeValid) {
			throw new \Exception('Invalid grant type');
		}

		if($mustValidateSecret && $client->getClientSecret() != $clientSecret) {
			throw new \Exception('Invalid client secret');
		}

		return $client;

	}

}