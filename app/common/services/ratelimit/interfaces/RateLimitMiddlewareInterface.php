<?php

namespace App\Common\Services\RateLimit\Interfaces;

use App\Common\Services\RateLimit\Exceptions\RateLimitException;

/**
 * Interface RateLimitMiddlewareInterface
 *
 * @package App\Common\Services\RateLimit
 */
interface RateLimitMiddlewareInterface {

    /**
     * Check if the current request is under the rate limit
     *
     * @throws RateLimitException
     */
	public function checkLimit();

}