<?php

$di->setShared(SERVICE_LOG, function() {
    return new App\Common\Services\Log(PATH_LOGS . '/errors-' . date('Y-m-d') . '.log');
});