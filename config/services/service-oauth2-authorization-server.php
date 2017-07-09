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
$di->setShared(SERVICE_OAUTH2_AUTHORIZATION_SERVER, function() use ($di, $settings) {

	// Init our repositories
	$clientRepository = new App\OAuth2\Entities\Repositories\Oauth2ClientRepository();
	$scopeRepository = new \App\OAuth2\Entities\Repositories\Oauth2ScopeRepository();
	$accessTokenRepository = new \App\OAuth2\Entities\Repositories\Oauth2AccessTokenRepository();
	$authCodeRepository = new \App\OAuth2\Entities\Repositories\Oauth2AuthCodeRepository();
	$refreshTokenRepository = new \App\OAuth2\Entities\Repositories\Oauth2RefreshTokenRepository();
	$userRepository = new \App\OAuth2\Entities\Repositories\Oauth2UserRepository();

	$privateKey = PATH_CONFIGURATION . 'keys/private.key';
	$publicKey = PATH_CONFIGURATION . 'keys/public.cert';


    // Init response
    $responseType = $di->getRequest()->getPost('type');
    if($responseType == 'bearer') {
        $response = null;
    } else {
        $response = new \App\Common\Classes\Responses\Psr7Response();
    }

	// Setup the authorization server
	$server = new \League\OAuth2\Server\AuthorizationServer(
		$clientRepository,
		$accessTokenRepository,
		$scopeRepository,
		$privateKey,
		$publicKey,
        $response
	);

	// Define default ttl in case it's omitted in config file
	$defaultAuthCodeTtl = new \DateInterval('PT10M'); // authorization codes will expire after 10 minutes
	$defaultAccessTokenTtl = new \DateInterval('PT1H'); // access tokens will expire after 1 hour
	$refreshAccessTokenTtl = new \DateInterval('P1M'); // refresh tokens will expire after 1 month

    // Add support for authorization code grant
	if(!empty($settings['oauth2']['grants']['authorization_code']['activated'])) {

        $grant = new \League\OAuth2\Server\Grant\AuthCodeGrant(
            $authCodeRepository,
            $refreshTokenRepository,
            (!empty($settings['oauth2']['grants']['authorization_code']['auth_code_ttl'])
                ? $settings['oauth2']['grants']['authorization_code']['auth_code_ttl']
                : $defaultAuthCodeTtl
            )
        );

        $grant->setRefreshTokenTTL(
            !empty($settings['oauth2']['grants']['authorization_code']['refresh_token_ttl'])
                ? $settings['oauth2']['grants']['authorization_code']['refresh_token_ttl']
                : $refreshAccessTokenTtl
        );

        // Enable the authentication code grant on the server
        $server->enableGrantType(
            $grant,
            (!empty($settings['oauth2']['grants']['authorization_code']['access_token_ttl'])
                ? $settings['oauth2']['grants']['authorization_code']['access_token_ttl']
                : $defaultAccessTokenTtl
            )
        );

    }

    // Add support for client credentials grant
    if(!empty($settings['oauth2']['grants']['client_credentials']['activated'])) {

        $clientCredentialGrant = new \League\OAuth2\Server\Grant\ClientCredentialsGrant();

        // Enable the client credentials grant on the server
        $server->enableGrantType(
            $clientCredentialGrant,
            (!empty($settings['oauth2']['grants']['client_credentials']['access_token_ttl'])
                ? $settings['oauth2']['grants']['client_credentials']['access_token_ttl']
                : $defaultAccessTokenTtl
            )
        );

    }

    // Add support for refresh token grant
    if(!empty($settings['oauth2']['grants']['refresh_token']['activated'])) {

        $grant = new \App\OAuth2\Classes\PlainRefreshTokenGrant($refreshTokenRepository);

        $grant->setRefreshTokenTTL(
            !empty($settings['oauth2']['grants']['refresh_token']['refresh_token_ttl'])
                ? $settings['oauth2']['grants']['refresh_token']['refresh_token_ttl']
                : $refreshAccessTokenTtl
        );

        // Enable the refresh token grant on the server
        $server->enableGrantType(
            $grant,
            (!empty($settings['oauth2']['grants']['refresh_token']['access_token_ttl'])
                ? $settings['oauth2']['grants']['refresh_token']['access_token_ttl']
                : $defaultAccessTokenTtl
            )
        );

    }

    // Add support for password grant
    if(!empty($settings['oauth2']['grants']['password']['activated'])) {

        $grant = new \League\OAuth2\Server\Grant\PasswordGrant(
            $userRepository,
            $refreshTokenRepository
        );

        $grant->setRefreshTokenTTL(
            !empty($settings['oauth2']['grants']['password']['refresh_token_ttl'])
                ? $settings['oauth2']['grants']['password']['refresh_token_ttl']
                : $refreshAccessTokenTtl
        );

        // Enable the password grant on the server
        $server->enableGrantType(
            $grant,
            (!empty($settings['oauth2']['grants']['password']['access_token_ttl'])
                ? $settings['oauth2']['grants']['password']['access_token_ttl']
                : $defaultAccessTokenTtl
            )
        );

    }

	return $server;

});