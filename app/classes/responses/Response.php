<?php

namespace App\Classes\Responses;

use App\Services\Log;
use Phalcon\DI;
use Phalcon\Exception;
use Phalcon\Http\Response as PhalconResponse;

/**
 * Class Response
 *
 * @package App\Classes\Responses
 */
class Response extends PhalconResponse {

    /** @var int Response default HTTP code */
    protected $code = 200;

    /** @var string Response default HTTP version */
    public static $defaultHttpVersion = '1.1';

    /** @var array[int]string Available HTTP codes */
    public static $availableHttpCodes = [

        // Information Codes
        100 => 'Continue',
        101 => 'Switching Protocols',

        // Success Codes
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',

        // Redirection Codes
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Moved Temporarily',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',

        // Client Errors
        400 => 'Bad Request',
        401 => 'Unauthorized',
        // 402 => 'Payment Required', // Not available with HTTP
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested range unsatisfiable',
        417 => 'Expectation failed',
        422 => 'Unprocessable Entity',

        // Server Errors
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',

    ];

    /**
     * JSONResponse constructor
     *
     * @param int $code
     * @param string $data
     *
     * @throws Exception
     */
    public function __construct(int $code, string $data = '') {

        if(!isset(self::$availableHttpCodes[$code])) {
            throw new Exception('Unavailable HTTP code in response');
        }

        if(in_array($code, [500]) && isset($data['debug'])) {

            // @TODO: Pass full exception in parameters
            /** @var Log $logService */
            $logService = Di::getDefault()->getShared(SERVICE_LOG);
            $logService->error($data['debug']);

        }

        if(APPLICATION_ENV === 'prod') {
            unset($data['debug']);
        }

        parent::__construct($data, $code, self::$availableHttpCodes[$code]);

    }

    /**
     * Send response
     *
     * @TODO: Define Access-Control header values in configuration
     */
    public function send() {

        header('HTTP/' . self::$defaultHttpVersion .' ' . $this->getStatusCode());
	    header('Access-Control-Allow-Origin: *');
	    header('Access-Control-Allow-Headers: X-Requested-With');
	    header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
	    echo $this->getContent();
        die;

    }
        
}