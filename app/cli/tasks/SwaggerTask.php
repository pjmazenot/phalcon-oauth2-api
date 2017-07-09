<?php

namespace App\Cli\Tasks;

use Phalcon\Cli\Task;

/**
 * Class SwaggerTask
 *
 * @package App\Cli\Tasks
 */
class SwaggerTask extends Task {

	public function generateAction() {

		// Scanning the app for Swagger notations
		echo 'Scanning app (' . PATH_APPLICATION . ')...' . PHP_EOL;
		$swagger = \Swagger\scan(PATH_APPLICATION);
		echo 'App scanned' . PHP_EOL;

		// Generating the json Swagger file for Swagger UI
		echo 'Generating json file (' . PATH_PUBLIC . '/docs/swagger/specs/app.json' . ')...' . PHP_EOL;
		file_put_contents(PATH_PUBLIC . '/docs/swagger/specs/app.json', $swagger);
		echo 'Json file generated' . PHP_EOL;

		echo 'Done!' . PHP_EOL;

	}

}
