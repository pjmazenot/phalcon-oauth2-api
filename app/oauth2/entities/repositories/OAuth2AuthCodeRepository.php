<?php

namespace App\OAuth2\Entities\Repositories;

use App\OAuth2\Entities\OAuth2AuthCode;
use App\OAuth2\Entities\OAuth2AuthCodeScope;
use App\OAuth2\Entities\OAuth2Session;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;

/**
 * Class Oauth2AuthCodeRepository
 *
 * @package App\OAuth2\Entities\Repositories
 */
class Oauth2AuthCodeRepository implements AuthCodeRepositoryInterface {

	/**
	 * Creates a new AuthCode
	 *
	 * @return AuthCodeEntityInterface
	 */
	public function getNewAuthCode() {

		$authCode = new OAuth2AuthCode();

		return $authCode;

	}

	/**
	 * Persists a new auth code to permanent storage.
	 *
	 * @param AuthCodeEntityInterface $authCodeEntity
	 * @throws \Exception
	 */
	public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity) {

		/** @var OAuth2AuthCode $authCodeEntity */
		if($authCodeEntity->getOauth2SessionId() == null) {

			// Create new session
			$session = new OAuth2Session();
			$session->setOauth2ClientId($authCodeEntity->getClient()->getId());
			$session->setOauth2UserId($authCodeEntity->getUserIdentifier());
			$session->setCreatedAt(date('Y-m-d H:i:s'));
			if(!$session->save()) {
				throw new \Exception('Unable to save the session');
			}

			$authCodeEntity->setOauth2SessionId($session->getId());

		}

		if(!$authCodeEntity->save()) {
			throw new \Exception('Unable to save the auth code');
		}

		$scopes = $authCodeEntity->getScopes();
		foreach ($scopes as $scope) {

			$accessTokenScope = new OAuth2AuthCodeScope();
			$accessTokenScope->setOauth2AuthCodeId($authCodeEntity->getId());
			$accessTokenScope->setOauth2ScopeId($scope->getId());
			if(!$accessTokenScope->save()) {
				throw new \Exception('Unable to save the auth code scope');
			}

		}

	}

	/**
	 * Revoke an auth code.
	 *
	 * @param string $codeId
	 * @throws \Exception
	 */
	public function revokeAuthCode($codeId) {

		/** @var OAuth2AuthCode $authCode */
		$authCode = OAuth2AuthCode::findFirst('code = "' . $codeId . '"');

		if($authCode) {
			$authCode->setIsRevoked(true);
			$authCode->save();
		} else {
			throw new \Exception('Unable to revoke the auth code');
		}

	}

	/**
	 * Check if the auth code has been revoked.
	 *
	 * @param string $codeId
	 *
	 * @return bool Return true if this code has been revoked
	 */
	public function isAuthCodeRevoked($codeId) {

		/** @var OAuth2AuthCode $authCode */
		$authCode = OAuth2AuthCode::findFirst('code = "' . $codeId . '"');

		return empty($authCode) || $authCode->getIsRevoked();

	}

}