<?php

namespace App\Services\RateLimit;

use App\Services\RateLimit\Exceptions\RateLimitException;
use App\Services\RateLimit\Interfaces\RateLimitMiddlewareInterface;
use App\Services\RateLimit\Interfaces\RateLimitRuleInterface;
use App\Services\Storage\FileSystem\File;
use Phalcon\Http\Request as PhalconRequest;
use Phalcon\Http\Response as PhalconResponse;

/**
 * Class RateLimiterMiddlewareCustom
 *
 * @TODO: Add enpoint check to allow to fix limits by endpoint
 *
 * @package App\Services\RateLimit
 */
class RateLimitMiddlewareCustom implements RateLimitMiddlewareInterface {

	/** @var PhalconRequest $request */
	protected $request;

	/** @var PhalconResponse $response */
	protected $response;

	/** @var RateLimitRuleInterface[] $rules */
	protected $rules;

	/** @var string $identifier */
	protected $identifier;

	/** @var File $file */
	protected $file;

    /**
     * RateLimiter constructor.
     *
     * @param PhalconRequest $request
     * @param PhalconResponse $response
     * @param string $identifier
     * @param RateLimitRuleInterface[] $rules
     */
    public function __construct(PhalconRequest $request, PhalconResponse $response, $identifier, array $rules)
    {

	    $this->request = $request;
	    $this->response = $response;
	    $this->identifier = substr(md5($identifier), 0, 9);
	    $this->rules = $rules;

    }

    /**
     * @inheritdoc
     */
    public function checkLimit() {

	    // Create the cache folder if needed
	    if(!is_dir(PATH_APPLICATION . '/cache/api/rate-limit/')) {
		    mkdir(PATH_APPLICATION . '/cache/api/rate-limit/', 0775, true);
	    }

	    // Open the rate limit file
		$filename = PATH_APPLICATION . '/cache/api/rate-limit/' . $this->identifier;
	    $this->file = new File($filename, 'c+');

	    // Lock the file to prevent another process from writing in it
	    $this->file->lock();

	    $currentTimestamp = time();
	    $resetValues = [];

	    // Store max reset timestamps from rules
	    foreach ($this->rules as $rule) {

		    $resetValues[$rule->getIdentifier()] = [
		    	'reset_max' => $rule->getMaxResetTimestamp(),
			    'limit' => $rule->getCallLimit(),
			    'count' => 0
		    ];

	    }

	    // Process every logged calls
	    while($line = $this->file->getNextLine(PHP_EOL)) {

		    if(empty($line)) {
			    continue;
		    }

		    // Parse data from line
		    $lineData = \GuzzleHttp\json_decode(trim($line), true);

		    // Loop the reset timestamps (one by rule)
		    foreach ($lineData['reset_timestamps'] as $index => $callResetTimestampData) {

                list($ruleIdentifier, $callResetTimestamp) = $callResetTimestampData;

			    // Check if the timestamp is still applicable for the rule
                if(!isset($resetValues[$ruleIdentifier]) || time() > $callResetTimestamp) {
				    unset($lineData['reset_timestamps'][$index]);
			    } else {
				    $resetValues[$ruleIdentifier]['count']++;
			    }

		    }

            if(empty($lineData['reset_timestamps'])) {
                continue;
            } else {

                $lineData['reset_timestamps'] = array_values($lineData['reset_timestamps']);

                $this->file->addToBuffer(\GuzzleHttp\json_encode($lineData) . PHP_EOL);

            }

	    }

        $this->file->truncate(0);
	    $this->file->append($this->file->getBuffer());

	    list($endpoint, ) = explode('?', $this->request->getURI());
	    $newLineData = [
	    	'endpoint' => $this->request->getMethod() . ' ' . $endpoint,
		    'reset_timestamps' => []
	    ];

	    // process the current call
	    foreach ($this->rules as $rule) {

		    // Define current call data
		    $currentCallData = [
			    'current_timestamp' => time(),
			    'current_call_count' => $resetValues[$rule->getIdentifier()]['count']
		    ];

		    $passedValidation = $rule->validate($currentCallData);

		    if(!$passedValidation) {
			    throw new RateLimitException('You reach your api rate limit, please try again later');
		    }

		    $newLineData['reset_timestamps'][] = [
		    	$rule->getIdentifier(),
		        $rule->getMaxResetTimestamp()
		    ];

	    }

	    // Close the file
	    $this->file->append(\GuzzleHttp\json_encode($newLineData) . PHP_EOL);
	    $this->file->close();

    }

}