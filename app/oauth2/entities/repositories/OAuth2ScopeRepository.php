<?php

namespace App\OAuth2\Entities\Repositories;

use App\OAuth2\Entities\OAuth2Client;
use App\OAuth2\Entities\OAuth2Scope;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

/**
 * Class Oauth2ScopeRepository
 *
 * @package App\OAuth2\Entities\Repositories
 */
class Oauth2ScopeRepository implements ScopeRepositoryInterface  {

	/**
	 * Return information about a scope.
	 *
	 * @param string $identifier The scope identifier
	 *
	 * @return ScopeEntityInterface
	 */
	public function getScopeEntityByIdentifier($identifier) {

		/** @var OAuth2Scope $scope */
		$scope = OAuth2Scope::findFirst('scope = "' . $identifier . '"');

		return $scope;

	}

	/**
	 * Given a client, grant type and optional user identifier validate the set of scopes requested are valid and optionally
	 * append additional scopes or remove requested scopes.
	 *
	 * @param ScopeEntityInterface[] $scopes
	 * @param string                 $grantType
	 * @param ClientEntityInterface  $clientEntity
	 * @param null|string            $userIdentifier
	 *
	 * @return ScopeEntityInterface[]
	 */
	public function finalizeScopes(
		array $scopes,
		$grantType,
		ClientEntityInterface $clientEntity,
		$userIdentifier = null
	) {

		// @TODO: Set the grant types on the scope link to the client

		/** @var OAuth2Client $clientEntity */
		$authorizedScopes = $clientEntity->getScopes();
		$finalScopes = [];

		foreach($authorizedScopes as $authorizedScope) {

			if(in_array($authorizedScope->getScope(), $scopes)) {
				$finalScopes[] = $authorizedScope->getScope();
			}

		}

		// @TODO: Set specific scopes for users

		return $finalScopes;

	}

}