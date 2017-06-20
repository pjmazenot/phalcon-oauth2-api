<?php

// @TODO: Put examples/conditions for different DBMS
// new \Phalcon\Db\Adapter\Pdo\Postgesql($creds)
// new \Phalcon\Db\Adapter\Pdo\Sqlite($creds)
// Not supported

/**
 * Default database service, duplicate if you need multiple database connections
 */
$di->set(SERVICE_DATABASE_DEFAULT, function() use ($settings) {

    try {

        $client = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            'host' => $settings['database']['hostname'],
            'username' => $settings['database']['username'],
            'password' => $settings['database']['password'],
            'dbname' => $settings['database']['dbname'],
            'options' => array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $settings['database']['charset']
            )
        ));

    } catch(PDOException $e) {

	    // Second try with dsn (fix connection error with some unix system)
	    if($settings['database']['dsn']) {

		    try {

			    $client = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
				    'dsn' => $settings['database']['dsn'],
				    'host' => $settings['database']['hostname'],
				    'username' => $settings['database']['username'],
				    'password' => $settings['database']['password'],
				    'dbname' => $settings['database']['dbname'],
				    'options' => array(
					    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $settings['database']['charset']
				    )
			    ));

		    } catch(PDOException $e) {
			    throw new \Exception('Unable to connect to the database: ' . $settings['database']['dbname']);
		    }

	    } else {
		    throw new \Exception('Unable to connect to the database: ' . $settings['database']['dbname']);
	    }

    }

	return $client;

});