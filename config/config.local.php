<?php
$settings = [
    'application' => [
        'environment' => 'local',
        'name' => 'Phalcon OAuth2 Server + API',
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
    'oauth2' => [
    	'grants' => [
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
	    'rate_limit' => [
	    	'default' => [
	    		'rules' => [
	    			new \App\Common\Services\RateLimit\RateLimitRule(10, 1),
	    			//new \App\Common\Services\RateLimit\RateLimitRule(30, 3600),
			    ]
		    ]
	    ]
    ],
];

if(php_sapi_name() === 'cli') {
    $settings['database']['hostname'] = '127.0.0.1';
}