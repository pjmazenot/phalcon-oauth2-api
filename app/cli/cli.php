<?php

require_once realpath(dirname(dirname(dirname(__FILE__)))) . '/config/constants.php';

require_once PATH_VENDOR . '/autoload.php';

require_once PATH_CONFIGURATION . '/loader.php';

// Init the task parameters
$env = null;
$arguments = [
    'task' => null,
    'action' => null,
    'params' => []
];

// Process the command arguments
foreach ($argv as $index => $arg) {
    if ($index == 1) {
        $arguments['task'] = $arg;
    } elseif ($index == 2) {
        $arguments['action'] = $arg;
    } elseif ($index == 3) {
        $env = $arg;
    } elseif ($index >= 4) {
        $arguments['params'][] = $arg;
    }
}

// Display an error if the environment does not exist
if(empty($arguments['task']) || empty($arguments['action']) || (!empty($env) && !in_array($env, ['-help', 'local', 'dev', 'prod']))) {
    echo 'Error in the command';
}

// Display the command help
if($env === '-help') {
    echo 'Command help';
}

// Using the CLI factory default services container
$di = new \Phalcon\Di\FactoryDefault\Cli();
$di->get('dispatcher')->setDefaultNamespace('App\Cli\Tasks');
$di->get('dispatcher')->setNamespaceName ('App\Cli\Tasks');

// Set environment
putenv('APPLICATION_ENV=' . (!empty($env) ? $env : 'local'));

// Get configuration
require PATH_CONFIGURATION . '/config.php';
require PATH_CONFIGURATION . '/services/service-databases.php';

// Create a console application
$console = new Phalcon\CLI\Console();
$console->setDI($di);

// Define global constants for the current task and action
define('CURRENT_TASK',   $arguments['task']);
define('CURRENT_ACTION', $arguments['action']);

try {
    // Handle incoming arguments
    $console->handle($arguments);
} catch (Exception $e) {
    echo $e->getMessage();
    exit(255);
}