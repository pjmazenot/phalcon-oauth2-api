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
    ]
];
