<?php
defined('IS_TEST')                || define('IS_TEST',                false);

// Define paths
defined('PATH_BASE')              || define('PATH_BASE',              realpath(dirname(dirname(__FILE__))));
defined('PATH_APPLICATION')       || define('PATH_APPLICATION',       PATH_BASE . '/app/');
defined('PATH_APPLICATION_CACHE') || define('PATH_APPLICATION_CACHE', PATH_APPLICATION . '/cache/');
defined('PATH_APPLICATION_CLI')   || define('PATH_APPLICATION_CLI',   PATH_APPLICATION . '/cli/');
defined('PATH_CONFIGURATION')     || define('PATH_CONFIGURATION',     PATH_BASE . '/config/');
defined('PATH_LOGS')              || define('PATH_LOGS',              PATH_BASE . '/logs/');
defined('PATH_PUBLIC')            || define('PATH_PUBLIC',            PATH_BASE . '/public/');
defined('PATH_TESTS')             || define('PATH_TESTS',             PATH_BASE . '/tests/');
defined('PATH_VENDOR')            || define('PATH_VENDOR',            PATH_BASE . '/vendor/');

// Services
defined('SERVICE_CONFIG')                      || define('SERVICE_CONFIG', 'config');
defined('SERVICE_DATABASE_DEFAULT')            || define('SERVICE_DATABASE_DEFAULT', 'db');
defined('SERVICE_LOG')                         || define('SERVICE_LOG', 'log');
defined('SERVICE_OAUTH2_AUTHORIZATION_SERVER') || define('SERVICE_OAUTH2_AUTHORIZATION_SERVER', 'oauth2-authorization-server');
defined('SERVICE_OAUTH2_RESOURCE_SERVER')      || define('SERVICE_OAUTH2_RESOURCE_SERVER', 'oauth2-resource-server');
