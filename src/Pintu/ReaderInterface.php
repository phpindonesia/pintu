<?php namespace Pintu;

interface ReaderInterface {

	const IDENTIFIER = '+CMGL:';

	/**
	 * Parse the service into array
	 *
	 * @param Service
	 * @return array
	 */
	public function get(Service $service);

}