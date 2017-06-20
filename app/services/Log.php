<?php

namespace App\Services;

use Phalcon\Exception;

/**
 * Class Log
 *
 * @package App\Services
 */
class Log {

    /** @var string $file */
    private $file;

    /**
     * Log constructor.
     *
     * @param null|string $file
     */
    public function __construct($file = null)
    {

        $this->setFile($file);

    }

    /**
     * Update the log file path
     *
     * @param string $file
     * @throws Exception
     */
    public function setFile($file) {

        $logDir = dirname($file);

        if(!is_dir($logDir)) {

            mkdir($logDir, 0775, true);

            if(!is_dir($logDir)) {
                throw new Exception('Log dir does not exist');
            }

        }

        $this->file = $file;

    }

    /**
     * Add an info entry into the log file
     *
     * @param string $message
     */
    public function info($message) {

        $content = date('Y-m-d H:i:s') . ' [INFO] - ' . $message;
        $this->write($content);

    }

    /**
     * Add a notice entry into the log file
     *
     * @param string $message
     */
    public function notice($message) {

        $content = date('Y-m-d H:i:s') . ' [NOTICE] - ' . $message;
        $this->write($content);

    }

    /**
     * Add a warning entry into the log file
     *
     * @param string $message
     */
    public function warning($message) {

        $content = date('Y-m-d H:i:s') . ' [WARNING] - ' . $message;
        $this->write($content);

    }

    /**
     * Add an error entry into the log file
     *
     * @param string $message
     */
    public function error($message) {

        $content = date('Y-m-d H:i:s') . ' [ERROR] - ' . $message;
        $this->write($content);

    }

    /**
     * Write an entry into the log file
     *
     * @link https://www.grobmeier.de/performance-ofnonblocking-write-to-files-via-php-21082009.html
     *
     * @param string $content
     *
     * @throws Exception
     */
    private function write($content) {

        if(empty($this->file)) {
            throw new Exception('Log file is not specified');
        }

        $fp = fopen($this->file, 'a+');
        stream_set_blocking($fp, 0);

        if (flock($fp, LOCK_EX)) {
            fwrite($fp, $content);
        }
        flock($fp, LOCK_UN);

        fclose($fp);

    }

}