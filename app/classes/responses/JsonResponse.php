<?php

namespace App\Classes\Responses;

use Phalcon\Exception;

/**
 * Class JsonResponse
 *
 * @package App\Classes\Responses
 */
class JsonResponse extends Response {

    /**
     * JsonResponse constructor
     *
     * @param int $code
     * @param array $data
     *
     * @throws Exception
     */
    public function __construct($code, array $data = []) {

        parent::__construct($code, json_encode($data));

        $this->setHeader('Content-type', 'application/json; charset=utf-8');

        // @TODO: Move this on config file
        $this->setHeader('Access-Control-Allow-Origin', '*');
        $this->setHeader('Access-Control-Allow-Headers', 'X-Requested-With');
        // @FIXME: Sometime return 500 error
        // header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');

    }
        
}