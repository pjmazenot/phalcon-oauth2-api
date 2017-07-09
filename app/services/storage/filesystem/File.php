<?php

namespace App\Services\Storage\FileSystem;

/**
 * Class File
 *
 * @package App\Services\Storage\FileSystem
 */
class File {

	/** @var string $filename */
	protected $filename;

	/** @var resource $resource */
	protected $resource;

	/** @var string $buffer */
	protected $buffer;

	/** @var bool $isLocked */
	protected $isLocked = false;

	/**
	 * File constructor.
	 *
	 * @param string $filename
	 * @param string $mode
	 * @param bool $useIncludePath
	 * @param null|resource $context
	 *
	 * @throws \Exception
	 */
	public function __construct($filename, $mode, $useIncludePath = false, $context = null) {

		$this->filename = $filename;

		if(!empty($context)) {
			$this->resource = fopen($filename, $mode, $useIncludePath, $context);
		} else {
			$this->resource = fopen($filename, $mode, $useIncludePath);
		}

		if(empty($this->resource)) {
			throw new \Exception('Unable to open the file: ' . $filename);
		}

	}

	/**
	 * @param string $unit
	 *
	 * @return float|int
	 * @throws \Exception
	 */
	public function getSize($unit = 'b') {

		$sizeInBytes = filesize($this->filename);

		switch ($unit) {

			case 'b': return $sizeInBytes;
			case 'kb': return round($sizeInBytes / 1024, 2);
			case 'Mb': return round($sizeInBytes / 1024^2, 2);
			case 'Gb': return round($sizeInBytes / 1024^3, 2);
			case 'Tb': return round($sizeInBytes / 1024^4, 2);
			case 'o': return round($sizeInBytes / 8, 2);
			case 'ko': return round($sizeInBytes / 8 / 1024, 2);
			case 'Mo': return round($sizeInBytes / 8 / 1024^2, 2);
			case 'Go': return round($sizeInBytes / 8 / 1024^3, 2);
			case 'To': return round($sizeInBytes / 8 / 1024^4, 2);
			default:
				throw new \Exception(__METHOD__ . '(): File size not supported');
				break;

		}

	}

	/**
	 * Get file content
	 *
	 * @param null|int $size
	 *
	 * @return string
	 */
	public function getContents($size = null) {

		if(!isset($size)) {
			$size = $this->getSize();
		}

		return fread($this->resource, $size);

	}

	/**
	 * Get the next line inf the file
	 *
	 * @param null|string $ending
     * @param int $length
	 *
	 * @return string
	 */
	public function getNextLine($ending = null, $length = 65535) {

		return stream_get_line($this->resource, $length, $ending);

	}

    /**
     * Get buffer contents
     *
     * @return string
     */
	public function getBuffer() {

		return $this->buffer;

	}

    /**
     * Set buffer contents
     *
     * @param string $string
     *
     * @return string
     */
	public function setBuffer($string) {

		return $this->buffer = $string;

	}

	/**
	 * Add data to buffer
	 *
	 * @param string $string
	 */
	public function addToBuffer($string) {

		if(!isset($this->buffer)) {
			$this->buffer = $string;
		} else {
			$this->buffer .= $string;
		}

	}

	public function prepend($string, $length = null, $lock = false) {

		$this->seek(0);
		$this->write($string, $length, $lock);

	}

	public function append($string, $length = null, $lock = false) {

		$this->seek(0, SEEK_END);
		return $this->write($string, $length, $lock);

	}

	public function seek($position, $whence = SEEK_SET) {

		fseek($this->resource, $position, $whence);

	}

	/**
	 * Write buffer to the file
	 *
	 * @param bool $lock
	 *
	 * @return int
	 */
	public function writeBuffer($lock = false) {

		return $this->write($this->buffer, null, $lock);

	}

	/**
	 * Write data to the file
	 *
	 * @param string $string
	 * @param null|int $length
	 * @param bool $lock
	 *
	 * @return int
	 * @throws \Exception
	 */
	public function write($string, $length = null, $lock = false) {

		if($lock) {

		    $this->lock();

			if ($this->isLocked) {

				$write = fwrite ($this->resource, $string, $length);
				fflush($this->resource);

				$this->unlock();

				return $write;

			} else {
				throw new \Exception(__METHOD__ . '(): Unable to lock the file');
			}

		} else {
			return fwrite ($this->resource, $string);
		}

	}

	/**
	 * Truncate the file
	 *
	 * @param int $size
	 */
	public function truncate($size = 0) {

	    ftruncate($this->resource, $size);
        rewind($this->resource);

	}

	/**
	 * Lock the file
	 */
	public function lock() {

		if (flock($this->resource, LOCK_EX)) {
			$this->isLocked = true;
		} else {
			throw new \Exception(__METHOD__ . '(): Unable to lock the file');
		}

	}

	/**
	 * Unlock the file
	 */
	public function unlock() {

		if($this->isLocked) {
			flock($this->resource, LOCK_UN);
		}

	}

	/**
	 * Close the connection
	 */
	public function close() {

		if($this->isLocked) {
			flock($this->resource, LOCK_UN);
		}

		fclose($this->resource);
		$this->resource = null;

	}

	/**
	 * Delete the file
	 */
	public function delete() {

		unlink($this->filename);

	}

}