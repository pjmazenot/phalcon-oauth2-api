<?php

namespace App\Services\RateLimit\Interfaces;

/**
 * Interface RateLimitRuleInterface
 *
 * @package App\Services\RateLimit
 */
interface RateLimitRuleInterface {

    /**
     * Get the max number of calls for this rule
     *
     * @return int
     */
	public function getCallLimit();

    /**
     * Get the max reset timestamp
     *
     * @return int
     */
	public function getMaxResetTimestamp();

	/**
	 * Process the rate limit rule
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function validate(array $data);

	/**
	 * Get the rule unique identifier
	 *
	 * @return string
	 */
	public function getIdentifier();

}