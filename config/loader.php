<?php

// Instantiate the loader
$loader = new \Phalcon\Loader();

// Register the tasks directory
$loader->registerDirs([
    PATH_APPLICATION . '/tasks/'
]);

// Register the namespaces
$loader->registerNamespaces([

    // App
    'App\Classes'                              => PATH_APPLICATION . '/classes/',
    'App\Classes\Requests'                     => PATH_APPLICATION . '/classes/requests/',
    'App\Classes\Responses'                    => PATH_APPLICATION . '/classes/responses/',
    'App\Controllers'                          => PATH_APPLICATION . '/controllers/',
    'App\Controllers\Oauth2'                   => PATH_APPLICATION . '/controllers/oauth2/',
    'App\Entities'                             => PATH_APPLICATION . '/entities/',
    'App\Entities\Base'                        => PATH_APPLICATION . '/entities/base/',
    'App\Entities\Model'                       => PATH_APPLICATION . '/entities/model/',
    'App\Entities\Repositories'                => PATH_APPLICATION . '/entities/repositories/',
    'App\Services'                             => PATH_APPLICATION . '/services/',

    // Tasks
    'App\Tasks'                                => PATH_APPLICATION . '/tasks/',

    // Tests (for later use)
    'App\Tests'                                => PATH_TESTS . '/App/',

]);

$loader->register();