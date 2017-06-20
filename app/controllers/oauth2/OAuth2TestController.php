<?php

namespace App\Controllers\OAuth2;

use App\Controllers\DefaultController;
use GuzzleHttp\Psr7\Response as Psr7Response;

/**
 * Class OAuth2TestController
 *
 * @package App\Controllers\OAuth2
 */
class OAuth2TestController extends DefaultController {

	public function test() {

	    $this->init();
	    $this->validateAuthorization();

	    $data = [
	        'method' => $this->getRequest()->getMethod(),
            'uri' => $this->getRequest()->getURI(),
            'authorized' => true
        ];

        $this->send(200, $data);

	}

}
