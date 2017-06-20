<?php

namespace App\Classes\Requests;

use GuzzleHttp\Psr7\ServerRequest;
use Phalcon\Http\Request as PhalconRequest;

/**
 * Class Psr7Request
 *
 * @package App\Classes\Requests
 */
class Psr7Request extends ServerRequest {

    /**
     * Psr7Request constructor.
     *
     * @param PhalconRequest $request
     */
    public function __construct(PhalconRequest $request)
    {

	    // Get the params from the original request
        $method = $request->getMethod();
        $uri = $request->getURI();
        $headers = $request->getHeaders();
        $version = '1.1';

	    // Forward the Authorization header (not working by default with Phalcon)
        if(empty($headers['Authorization']) && !empty($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            $headers['Authorization'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }

        parent::__construct($method, $uri, $headers, null, $version);

    }

	/**
	 * @param PhalconRequest $request
	 *
	 * @return Psr7Request
	 */
    public static function create(PhalconRequest $request) {

	    // Create the Psr7 request instance
        $psr7Request = new static($request);

	    // Define request body depending on the original request content type
	    $contentType = $request->getContentType();
	    switch ($contentType) {

		    case 'application/json':
			    $body = $request->getJsonRawBody();
			    break;

		    case 'application/x-www-form-urlencoded':
			    $rawBody = $request->getRawBody();
			    $urlParams = [];
			    parse_str($rawBody, $urlParams);
			    $body = (object)$urlParams;
		    	break;

		    case 'multipart/form-data':
			    $body = (object)$request->getPost();
			    break;

		    default:
		    	$body = (object)[];
			    break;

	    }

	    // Return the Psr7 request with the adapted body
        return $psr7Request->withParsedBody($body);

    }

}