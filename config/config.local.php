<?php

$settings = [
    'application' => [
        'environment' => 'local',
        'name' => 'Phalcon Oauth2 Server + API',
        'url' => 'http://api.oauth2.local/',
    ],
    'database' => [
        'dsn' => 'mysql:dbname=oauth2;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock;',
        'adapter'  => 'pdo',
        'driver'   => 'mysql',
        'username' => 'root',
        'password' => 'root',
        'hostname' => 'localhost',
        'port'     => 3306,
        'dbname'   => 'oauth2',
        'charset'   => 'utf8mb4',
    ],
];

if(php_sapi_name() === 'cli') {
    $settings['database']['hostname'] = '127.0.0.1';
}