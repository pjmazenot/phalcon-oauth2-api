<?php
$settings = [
    'application' => [
	    'environment' => 'prod',
	    'name' => 'Phalcon Oauth2 Server + API',
	    'url' => 'http://api.oauth2.com/',
    ],
    'database' => [
	    'adapter'  => 'pdo',
	    'driver'   => 'mysql',
	    'username' => 'root',
	    'password' => 'root',
	    'hostname' => 'localhost',
	    'port'     => 3306,
	    'dbname'   => 'oauth2',
	    'charset'   => 'utf8mb4',
    ],
    'oauth2' => [
        'authorization_code' => [
            'activated' => true,
            'auth_code_ttl' => new \DateInterval('PT10M'),
            'access_token_ttl' => new \DateInterval('PT1H'),
            'refresh_token_ttl' => new \DateInterval('P1M'),
        ],
        'client_credentials' => [
            'activated' => true,
            'access_token_ttl' => new \DateInterval('PT1H'),
        ],
        'refresh_token' => [
            'activated' => true,
            'access_token_ttl' => new \DateInterval('PT1H'),
            'refresh_token_ttl' => new \DateInterval('P1M'),
        ],
        'password' => [
            'activated' => true,
            'access_token_ttl' => new \DateInterval('PT1H'),
            'refresh_token_ttl' => new \DateInterval('P1M'),
        ],
    ],
];
