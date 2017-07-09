<?php

namespace App\OAuth2\Entities\Repositories;

use App\OAuth2\Entities\OAuth2User;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use Phalcon\Mvc\Model\Resultset\Simple;

/**
 * Class Oauth2UserRepository
 *
 * @package App\OAuth2\Entities\Repositories
 */
class Oauth2UserRepository implements UserRepositoryInterface  {

	/**
	 * Get a user entity.
	 *
	 * @param string                $username
	 * @param string                $password
	 * @param string                $grantType    The grant type used
	 * @param ClientEntityInterface $clientEntity
	 *
	 * @return UserEntityInterface|bool
	 */
	public function getUserEntityByUserCredentials(
		$username,
		$password,
		$grantType,
		ClientEntityInterface $clientEntity
	) {

		// Get attachments
		// A raw SQL statement
		$sql = 'SELECT u.* 
		FROM oauth2_user AS u
		JOIN oauth2_client_user AS cu ON cu.oauth2_user_id = u.id
		JOIN oauth2_client_grant_type AS cgt ON cgt.oauth2_client_id = cu.oauth2_client_id
		JOIN oauth2_grant_type AS gt ON cgt.oauth2_grant_type_id = gt.id
		WHERE 
			u.username = "' . $username . '"
			AND u.password = "' . hash('sha512', $password) . '"
			AND cu.oauth2_client_id = ' . $clientEntity->getIdentifier() . ' 
			AND gt.grant_type = "' . $grantType . '"
		LIMIT 1';

		// Base model
		$user = new OAuth2User();

		// Execute the query
		$users = new Simple(
			null,
			$user,
			$user->getReadConnection()->query($sql)
		);

		return !empty($users[0]) ? $users[0] : false;

	}

}