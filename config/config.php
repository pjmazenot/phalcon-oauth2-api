<?php
date_default_timezone_set('America/Montreal');

$settings = [];
global $settings;

$env = getenv('APPLICATION_ENV');

if (
    $env === 'local'
    || !isset($_SERVER['HTTP_CLIENT_IP'])
    && !isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    && in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', 'fe80::1', '::1'])
) {

    include dirname(__FILE__) . '/config.local.php';

} else {

    include dirname(__FILE__) . '/config.prod.php';

}

defined('APPLICATION_ENV') || define('APPLICATION_ENV', $env);