<?php

require PATH_CONFIGURATION . '/config.php';

/*
 * Service OAuth2
 *
 * @TODO: Create a OAuth2 resource server service class
 *
 * @link https://oauth2.thephpleague.com/
 * @link https://stackoverflow.com/questions/3598044/openssl-verify-and-error0906d06cpem-routinespem-read-biono-start-line
 *
 * Use the CryptKey class to load the private key if a passphrase is set
 * E.g: $privateKey = new CryptKey('file://path/to/private.key', 'passphrase');
 */
$di->setShared(SERVICE_OAUTH2_RESOURCE_SERVER, function() /* use ($settings) */ {

	// Init our repositories
	$accessTokenRepository = new \App\Entities\Repositories\Oauth2AccessTokenRepository(); // instance of AccessTokenRepositoryInterface

    $publicKey = PATH_CONFIGURATION . 'keys/public.cert';

	// Setup the authorization server
    $server = new \League\OAuth2\Server\ResourceServer(
        $accessTokenRepository,
        $publicKey
    );

	return $server;

});