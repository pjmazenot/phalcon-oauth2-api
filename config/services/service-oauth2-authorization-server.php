<?php

require PATH_CONFIGURATION . '/config.php';

/*
 * Service OAuth2
 *
 * @TODO: Create a OAuth2 authorization server service class
 *
 * @link https://oauth2.thephpleague.com/
 * @link https://stackoverflow.com/questions/3598044/openssl-verify-and-error0906d06cpem-routinespem-read-biono-start-line
 *
 * Use the CryptKey class to load the private key if a passphrase is set
 * E.g: $privateKey = new CryptKey('file://path/to/private.key', 'passphrase');
 */
$di->setShared(SERVICE_OAUTH2_AUTHORIZATION_SERVER, function() /* use ($settings) */ {

	// Init our repositories
	$clientRepository = new App\Entities\Repositories\Oauth2ClientRepository(); // instance of ClientRepositoryInterface
	$scopeRepository = new \App\Entities\Repositories\Oauth2ScopeRepository(); // instance of ScopeRepositoryInterface
	$accessTokenRepository = new \App\Entities\Repositories\Oauth2AccessTokenRepository(); // instance of AccessTokenRepositoryInterface
	$authCodeRepository = new \App\Entities\Repositories\Oauth2AuthCodeRepository(); // instance of AuthCodeRepositoryInterface
	$refreshTokenRepository = new \App\Entities\Repositories\Oauth2RefreshTokenRepository(); // instance of RefreshTokenRepositoryInterface
	$userRepository = new \App\Entities\Repositories\Oauth2UserRepository(); // instance of RefreshTokenRepositoryInterface

	$privateKey = PATH_CONFIGURATION . 'keys/private.key';
	$publicKey = PATH_CONFIGURATION . 'keys/public.cert';

	// Setup the authorization server
	$server = new \League\OAuth2\Server\AuthorizationServer(
		$clientRepository,
		$accessTokenRepository,
		$scopeRepository,
		$privateKey,
		$publicKey
	);
	$grant = new \League\OAuth2\Server\Grant\AuthCodeGrant(
		$authCodeRepository,
		$refreshTokenRepository,
		new \DateInterval('PT10M') // authorization codes will expire after 10 minutes
	);

	$grant->setRefreshTokenTTL(new \DateInterval('P1M')); // refresh tokens will expire after 1 month

	// Enable the authentication code grant on the server
	$server->enableGrantType(
		$grant,
		new \DateInterval('PT1H') // access tokens will expire after 1 hour
	);

	// Enable the client credentials grant on the server
	$server->enableGrantType(
		new \League\OAuth2\Server\Grant\ClientCredentialsGrant(),
		new \DateInterval('PT1H') // access tokens will expire after 1 hour
	);


	$grant = new \League\OAuth2\Server\Grant\RefreshTokenGrant($refreshTokenRepository);
	$grant->setRefreshTokenTTL(new \DateInterval('P1M')); // new refresh tokens will expire after 1 month

	// Enable the refresh token grant on the server
	$server->enableGrantType(
		$grant,
		new \DateInterval('PT1H') // new access tokens will expire after an hour
	);


    $grant = new \League\OAuth2\Server\Grant\PasswordGrant(
        $userRepository,
        $refreshTokenRepository
    );

    $grant->setRefreshTokenTTL(new \DateInterval('P1M')); // refresh tokens will expire after 1 month

    // Enable the password grant on the server
    $server->enableGrantType(
        $grant,
        new \DateInterval('PT1H') // access tokens will expire after 1 hour
    );

	return $server;

});