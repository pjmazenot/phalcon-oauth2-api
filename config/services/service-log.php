<?php

$di->setShared(SERVICE_LOG, function() {
    return new App\Services\Log(PATH_LOGS . '/errors-' . date('Y-m-d') . '.log');
});