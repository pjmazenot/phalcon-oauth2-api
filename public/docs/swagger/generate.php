<?php
$baseDir = dirname(dirname(dirname(dirname(__FILE__))));

// Loading vendors
echo 'Loading libraries' . PHP_EOL;
require_once $baseDir . '/vendor/autoload.php';

// Scanning the app for Swagger notations
echo 'Scanning app (' . $baseDir . '/app' . ')...' . PHP_EOL;
$swagger = \Swagger\scan($baseDir . '/app');
echo 'App scanned' . PHP_EOL;

// Generating the json Swagger file for Swagger UI
echo 'Generating json file (' . __DIR__ . '/specs/app.json' . ')...' . PHP_EOL;
file_put_contents(__DIR__ . '/specs/app.json', $swagger);
echo 'Json file generated' . PHP_EOL;

echo 'Done!' . PHP_EOL;