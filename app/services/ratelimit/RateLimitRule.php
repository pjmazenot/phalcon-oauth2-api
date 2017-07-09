<?php

namespace App\Services\RateLimit;

use App\Services\RateLimit\Interfaces\RateLimitRuleInterface;
use Phalcon\Http\Request as PhalconRequest;

/**
 * Class RateLimiterRule
 *
 * @package App\Services\RateLimit
 */
class RateLimitRule implements RateLimitRuleInterface {

	/** @var int $callLimit */
	public $callLimit;

	/** @var int $timeLimit */
	public $timeLimit;

	/**
	 * RateLimiterRule constructor.
	 *
	 * @param int $callLimit
	 * @param int $timeLimit
	 */
	public function __construct($callLimit, $timeLimit) {

		$this->callLimit = $callLimit;
		$this->timeLimit = $timeLimit;

	}

    /**
     * @inheritdoc
     */
	public function getCallLimit() {

		return $this->callLimit;

	}

    /**
     * @inheritdoc
     */
	public function getMaxResetTimestamp() {

		return time() + $this->timeLimit;

	}

	/**
     * Process the rate limit rule
     *
     * Data passed in the array:
     *  - current_call_count
     *
     * @param array $data
     *
     * @return bool
	 */
	public function validate(array $data) {

		if($data['current_call_count'] < $this->callLimit) {
			return true;
		}

		return false;

	}

    /**
     * @inheritdoc
     */
	public function getIdentifier() {

		return substr(md5($this->callLimit . '-' . $this->timeLimit), 0, 9);

	}

}