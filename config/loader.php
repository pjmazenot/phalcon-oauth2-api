<?php

// Instantiate the loader
$loader = new \Phalcon\Loader();

// Register the tasks directory
$loader->registerDirs([
	PATH_APPLICATION_CLI . '/tasks/'
]);

// Register the namespaces
$loader->registerNamespaces([

    // Cli
    'App\Cli\Tasks'                                     => PATH_APPLICATION_CLI . '/tasks/',

    // Common
    'App\Common\Classes'                                => PATH_APPLICATION . '/common/classes/',
    'App\Common\Classes\Entities'                       => PATH_APPLICATION . '/common/classes/entities/',
    'App\Common\Classes\Requests'                       => PATH_APPLICATION . '/common/classes/requests/',
    'App\Common\Classes\Responses'                      => PATH_APPLICATION . '/common/classes/responses/',
    'App\Common\Controllers'                            => PATH_APPLICATION . '/common/controllers/',
    'App\Common\Services'                               => PATH_APPLICATION . '/common/services/',
    'App\Common\Services\RateLimit'                     => PATH_APPLICATION . '/common/services/ratelimit/',
    'App\Common\Services\RateLimit\Exceptions'          => PATH_APPLICATION . '/common/services/ratelimit/exceptions/',
    'App\Common\Services\RateLimit\Interfaces'          => PATH_APPLICATION . '/common/services/ratelimit/interfaces/',
    'App\Common\Services\Storage\FileSystem'            => PATH_APPLICATION . '/common/services/storage/filesystem/',

    // Api

    // OAuth2
    'App\OAuth2\Classes'                                => PATH_APPLICATION . '/oauth2/classes/',
    'App\OAuth2\Classes\Exceptions'                     => PATH_APPLICATION . '/oauth2/classes/exceptions',
    'App\OAuth2\Controllers'                            => PATH_APPLICATION . '/oauth2/controllers/',
    'App\OAuth2\Entities'                               => PATH_APPLICATION . '/oauth2/entities/',
    'App\OAuth2\Entities\Models'                        => PATH_APPLICATION . '/oauth2/entities/models/',
    'App\OAuth2\Entities\Repositories'                  => PATH_APPLICATION . '/oauth2/entities/repositories/',

    // Tests (for later use)
    'App\Tests'                                         => PATH_TESTS . '/App/',

]);

$loader->register();