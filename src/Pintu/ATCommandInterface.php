<?php namespace Pintu;

interface ATCommandInterface
{
	/**
	 * Return AT commands that need to be executed
	 *
	 * @return array
	 */
	public function all();
}