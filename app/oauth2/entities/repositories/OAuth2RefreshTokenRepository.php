<?php

namespace App\OAuth2\Entities\Repositories;

use App\OAuth2\Entities\OAuth2RefreshToken;
use League\OAuth2\Client\Grant\RefreshToken;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

/**
 * Class Oauth2RefreshTokenRepository
 *
 * @package App\OAuth2\Entities\Repositories
 */
class Oauth2RefreshTokenRepository implements RefreshTokenRepositoryInterface  {

	/**
	 * Creates a new refresh token
	 *
	 * @return RefreshTokenEntityInterface
	 */
	public function getNewRefreshToken() {

		$refreshToken = new OAuth2RefreshToken();

		return $refreshToken;

	}

	/**
	 * Create a new refresh token_name.
	 *
	 * @param RefreshTokenEntityInterface $refreshTokenEntity
	 * @throws \Exception
	 */
	public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity) {

	    /** @var RefreshToken $refreshTokenEntity */
        $refreshTokenEntity->setIssuedAt(date('Y-m-d H:i:s'));

		/** @var OAuth2RefreshToken $refreshTokenEntity */
		if(!$refreshTokenEntity->save()) {
			throw new \Exception('Unable to save the refresh token' . print_r($refreshTokenEntity->getMessages(), true));
		}

	}

	/**
	 * Revoke the refresh token.
	 *
	 * @param string $tokenId
	 * @throws \Exception
	 */
	public function revokeRefreshToken($tokenId) {

		/** @var OAuth2RefreshToken $accessToken */
		$accessToken = OAuth2RefreshToken::findFirst('refreshToken = "' . $tokenId . '"');

		if($accessToken) {
			$accessToken->setIsRevoked(true);
			$accessToken->save();
		} else {
			throw new \Exception('Unable to revoke the refresh token');
		}

	}

	/**
	 * Check if the refresh token has been revoked.
	 *
	 * @param string $tokenId
	 *
	 * @return bool Return true if this token has been revoked
	 */
	public function isRefreshTokenRevoked($tokenId) {

		/** @var OAuth2RefreshToken $accessToken */
		$accessToken = OAuth2RefreshToken::findFirst('refreshToken = "' . $tokenId . '"');

		return empty($accessToken) || $accessToken->getIsRevoked();

	}

}