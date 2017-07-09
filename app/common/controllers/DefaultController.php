<?php

namespace App\Common\Controllers;

use App\OAuth2\Classes\Exceptions\AuthenticationException;
use App\Common\Classes\Requests\Psr7Request;
use App\Common\Classes\Responses\JsonResponse;
use App\Common\Classes\Responses\XmlResponse;
use League\OAuth2\Server\ResourceServer;
use Phalcon\Di;
use Phalcon\Di\Injectable;
use Phalcon\Http\Request as PhalconRequest;
use Phalcon\Http\Response;

/**
 * Class DefaultController
 *
 * @package App\Common\Controllers
 */
class DefaultController extends Injectable {

	/** @var PhalconRequest $request */
	private $request;

	/** @var Psr7Request $request */
	private $psr7Request;

	/**
	 * Main constructor
	 */
	public function initialize() {

		$di = Di::getDefault();
		$this->setDI($di);

	}

	/**
	 * Init controller
	 */
	protected function init() {

		// Get request params
		$this->request = new PhalconRequest();
		$this->psr7Request = Psr7Request::create($this->request);

	}

    /**
     *
     * @throws AuthenticationException
     */
	protected function validateAuthorization() {

        /* @var ResourceServer $server */
        $server = $this->getDI()->get(SERVICE_OAUTH2_RESOURCE_SERVER);

        try {

            $server->validateAuthenticatedRequest($this->getPsr7Request());

        } catch (\Exception $e) {

            throw new AuthenticationException('Authentication error', null, $e);

        }

    }

    /**
     * Get current request
     *
     * @return PhalconRequest
     */
    protected function getRequest() {

	    return $this->request;

    }

    /**
     * Get current request (psr7)
     *
     * @return Psr7Request
     */
    protected function getPsr7Request() {

	    return $this->psr7Request;

    }

	/**
	 * Send the response to the client
	 *
	 * @param int $httpCode
	 * @param array $data
     *
     * @return Response
	 */
    protected function getResponse($httpCode, array $data) {

		$format = $this->request->get('format');

	    // @TODO: Move this part to the $app->after() method?
		switch ($format) {

			case 'xml':
				return new XmlResponse($httpCode, $data);
				break;

			case 'json':
			default:
				return new JsonResponse($httpCode, $data);
					break;

		}

	}

}
