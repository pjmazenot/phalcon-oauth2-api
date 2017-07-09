<?php

namespace App\Controllers;

use App\Classes\OAuth2\Exceptions\AuthenticationException;
use App\Classes\Requests\Psr7Request;
use App\Classes\Responses\JsonResponse;
use App\Classes\Responses\XmlResponse;
use League\OAuth2\Server\Middleware\ResourceServerMiddleware;
use League\OAuth2\Server\ResourceServer;
use Phalcon\Di;
use Phalcon\Di\Injectable;
use Phalcon\Http\Request as PhalconRequest;
use Phalcon\Http\Response;

/**
 * Class DefaultController
 *
 * @package App\Controllers
 *
 * @SWG\Swagger(
 *     info = @SWG\Info(
 *        description = "Phalcon API OAuth2 Server",
 *        version = "1.0.0-alpha",
 *        title = "Phalcon API OAuth2 Server"
 *     ),
 *     consumes = {"application/json"},
 *     produces = {"application/json"}
 * )
 *
 *
 * @SWG\Tag(
 *   name="oauth2",
 *   description="",
 * )
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
