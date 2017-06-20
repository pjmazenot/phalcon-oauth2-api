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
    public function __construct(int $code, array $data = []) {

        parent::__construct($code, json_encode($data));

    }

    /**
     * Send response
     */
    public function send() {

        header('HTTP/' . self::$defaultHttpVersion .' ' . $this->getStatusCode());
	    header('Access-Control-Allow-Origin: *');
	    header('Access-Control-Allow-Headers: X-Requested-With');
        header('Content-type: application/json; charset=utf-8');
        // @FIXME: Sometime return 500 error
	    // header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
	    echo $this->getContent();
        die;

    }
        
}