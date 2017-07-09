<?php

namespace App\Services\RateLimit;

use App\Services\RateLimit\Interfaces\RateLimitMiddlewareInterface;
use App\Services\RateLimit\Interfaces\RateLimitRuleInterface;
use Phalcon\Http\Request as PhalconRequest;

/**
 * Class RateLimiterMiddlewareStandard
 *
 * @package App\Services\RateLimit
 */
class RateLimitMiddlewareStandard implements RateLimitMiddlewareInterface {

	/** @var RateLimitRuleInterface[] $rules */
	protected $rules;

	protected $identifier;
	protected $file;

	// @TODO: Create the rate limiter with BCP headers
	// @limk https://stackoverflow.com/questions/16022624/examples-of-http-api-rate-limiting-http-response-headers

}