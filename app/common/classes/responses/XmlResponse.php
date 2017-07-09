<?php

namespace App\Common\Classes\Responses;

use Phalcon\Exception;

/**
 * Class XmlResponse
 *
 * @package App\Common\Classes\Responses
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
    public function __construct($code, array $data = []) {

	    // @TODO: Support XML output
	    // $xml = ArrayToXML::toXml($data);
	    $xml = '';

        parent::__construct($code, $xml);

        $this->setHeader('Content-type', 'application/xml; charset=utf-8');

        // @TODO: Move this on config file
        $this->setHeader('Access-Control-Allow-Origin', '*');
        $this->setHeader('Access-Control-Allow-Headers', 'X-Requested-With');
        // @FIXME: Sometime return 500 error
        // header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');

    }

    /**
     * Send response
     */
    public function send() {
	    echo $this->getContent();
        die;

    }
        
}