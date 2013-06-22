<?php namespace Pintu;

interface DIOSessionInterface 
{
	/**
	 * Factory method to manufacturing session
	 *
	 * @param $dsn The DSN to port/file
	 * @return DIOServiceInterface
	 * @throws InvalidArgumentException
	 */
	public static function create($dsn = '');

	/**
	 * Get current DSN
	 *
	 * @return string
	 */
	public function getDsn();

	/**
	 * Get current stream
	 * 
	 * @return resource
	 */
	public function getStream();
}