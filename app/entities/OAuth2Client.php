<?php

namespace App\Entities;

use App\Entities\Models\OAuth2ClientModel;
use App\Entities\Repositories\Oauth2ClientGrantTypeRepository;
use App\Entities\Repositories\OAuth2ClientScopeRepository;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\ClientTrait;

/**
 * Class OAuth2Client
 *
 * @package App\Entities
 */
class OAuth2Client extends OAuth2ClientModel implements ClientEntityInterface {

	/** @var OAuth2ClientEndpoint|OAuth2ClientEndpoint[] */
	protected $redirectUri;

	/** @var OAuth2ClientGrantType[] */
	protected $grantTypes;

	/** @var OAuth2ClientScope[] */
	protected $scopes;

    /**
     * Get the client's identifier.
     *
     * @return string
     */
    public function getIdentifier(): string {

        return (string)$this->getId();

    }

	/**
	 * Get the client's endpoints
	 *
	 * @return string|string[]
	 */
	public function getRedirectUri() {

		if(!isset($this->redirectUri)) {
			$this->redirectUri = OAuth2ClientEndpoint::find('oauth2ClientId = ' . $this->getId());
		}

		if(count($this->redirectUri) === 1) {
			return $this->redirectUri[0]->getRedirectUri();
		} elseif (count($this->redirectUri) > 1) {

			$redirectUri = [];
			foreach($this->redirectUri as $clientEndpoint) {
				$redirectUri[] = $clientEndpoint;
			}

			return $redirectUri;

		}

		return $this->redirectUri;

	}

	/**
	 * Set the client's endpoints
	 *
	 * @param array $redirectUris
	 */
	public function setRedirectUri(array $redirectUris)
	{

		$this->redirectUri = [];
		foreach($redirectUris as $redirectUri) {

			$clientEndpoint = new OAuth2ClientEndpoint();
			$clientEndpoint->setOauth2ClientId($this->getId());
			$clientEndpoint->setRedirectUri($redirectUri);

			$this->redirectUri[] = $clientEndpoint;

		}

	}

	/**
	 * Get scopes
	 *
	 * @return Oauth2GrantType[]
	 */
	public function getGrantTypes() {

		if(!isset($this->grantTypes)) {

			$clientGrantTypesRepository = new Oauth2ClientGrantTypeRepository();
            $this->grantTypes = $clientGrantTypesRepository->getGrantTypes($this);

		}

		return $this->grantTypes;

	}

	/**
	 * Get scopes
	 *
	 * @return OAuth2Scope[]
	 */
	public function getScopes() {

		if(!isset($this->scopes)) {

			$clientScopeRepository = new OAuth2ClientScopeRepository();
			$this->scopes = $clientScopeRepository->getScopes($this);

		}

		return $this->scopes;

	}

}