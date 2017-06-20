<?php

namespace App\Classes\Responses;

use Phalcon\Exception;
use Utilities\Outputformats\ArrayToXML;

/**
 * Class XmlResponse
 *
 * @package App\Classes\Responses
 */
class XmlResponse extends Response {

    /**
     * XmlResponse constructor
     *
     * @param int $code
     * @param array $data
     *
     * @throws Exception
     */
    public function __construct(int $code, array $data = []) {

	    // @TODO: Support XML output
	    // $xml = ArrayToXML::toXml($data);
	    $xml = '';

        parent::__construct($code, $xml);

    }

    /**
     * Send response
     */
    public function send() {

        header('HTTP/' . self::$defaultHttpVersion .' ' . $this->getStatusCode());
        header('Content-type: application/xml; charset=utf-8');
	    header('Access-Control-Allow-Origin: *');
	    header('Access-Control-Allow-Headers: X-Requested-With');
	    header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
	    echo $this->getContent();
        die;

    }
        
}