<?php

namespace App\Controllers;

use App\Classes\Requests\Psr7Request;
use App\Classes\Responses\JsonResponse;
use App\Classes\Responses\XmlResponse;
use League\OAuth2\Server\Middleware\ResourceServerMiddleware;
use League\OAuth2\Server\ResourceServer;
use Phalcon\Di;
use Phalcon\Di\Injectable;
use Phalcon\Http\Request as PhalconRequest;

/**
 * Class DefaultController
 *
 * @package App\Controllers
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
     */
	protected function validateAuthorization() {

        /* @var ResourceServer $server */
        $server = $this->getDI()->get(SERVICE_OAUTH2_RESOURCE_SERVER);

        try {
            $server->validateAuthenticatedRequest($this->getPsr7Request());
        } catch (\Exception $e) {

            $this->send(401, [
                'type' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

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
	 * @param array $response
	 */
    protected function send(int $httpCode, array $response) {

		$format = $this->request->get('format');

		switch ($format) {

			case 'xml':
				$response = new XmlResponse($httpCode, $response);
				$response->send();
				break;

			case 'json':
			default:
				$response = new JsonResponse($httpCode, $response);
				$response->send();
					break;

		}

	}

}
