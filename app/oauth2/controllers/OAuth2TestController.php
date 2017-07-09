<?php

namespace App\OAuth2\Controllers;

use App\OAuth2\Classes\Exceptions\AuthenticationException;
use App\Common\Controllers\DefaultController;

/**
 * Class OAuth2TestController
 *
 * @package App\OAuth2\Controllers
 */
class OAuth2TestController extends DefaultController {

    // @TODO: Add scope as prop or function (oauth2_test) as example for API controllers

	public function test() {

	    try {

            $this->init();
            $this->validateAuthorization();

            $data = [
                'method' => $this->getRequest()->getMethod(),
                'uri' => $this->getRequest()->getURI(),
                'authorized' => true
            ];

            return $this->getResponse(200, $data);

        } catch (AuthenticationException $e) {

            return $this->getResponse(401, [
                'message' => $e->getMessage(),
                'debug' => [
                    'type' => get_class($e->getPrevious()),
                    'file' => $e->getPrevious()->getFile(),
                    'line' => $e->getPrevious()->getLine()
                ]
            ]);

        }

	}

}
