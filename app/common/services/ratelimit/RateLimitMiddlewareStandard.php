<?php

namespace App\Common\Services\RateLimit;

use App\Common\Services\RateLimit\Interfaces\RateLimitMiddlewareInterface;
use App\Common\Services\RateLimit\Interfaces\RateLimitRuleInterface;

/**
 * Class RateLimiterMiddlewareStandard
 *
 * @package App\Common\Services\RateLimit
 */
class RateLimitMiddlewareStandard implements RateLimitMiddlewareInterface {

	/** @var RateLimitRuleInterface[] $rules */
	protected $rules;

	protected $identifier;
	protected $file;

	// @TODO: Create the rate limiter with BCP headers
	// @limk https://stackoverflow.com/questions/16022624/examples-of-http-api-rate-limiting-http-response-headers

    public function checkLimit() {
        return true;
    }

}