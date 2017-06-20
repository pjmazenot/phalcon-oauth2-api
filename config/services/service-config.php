<?php

require PATH_CONFIGURATION . '/config.php';

$di->setShared(SERVICE_CONFIG, function() use ($settings) {
    return new \Phalcon\Config($settings);
});