<?php

namespace App\Services\RateLimit\Interfaces;

use App\Services\RateLimit\Exceptions\RateLimitException;

/**
 * Interface RateLimitMiddlewareInterface
 *
 * @package App\Services\RateLimit
 */
interface RateLimitMiddlewareInterface {

    /**
     * Check if the current request is under the rate limit
     *
     * @throws RateLimitException
     */
	public function checkLimit();

}