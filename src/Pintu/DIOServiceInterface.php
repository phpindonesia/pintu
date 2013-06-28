<?php namespace Pintu;

use Pintu\DIOSessionInterface;
use Pintu\ATCommandInterface;

interface DIOServiceInterface
{
	/**
	 * Constructor
	 *
	 * @param DIOSessionInterface
	 * @param ATCommandInterface
	 */
	public function __construct(DIOSessionInterface $session, ATCommandInterface $command);

	/**
	 * Main API
	 */
	public function run();

	/**
	 * Run and get the array result
	 */
	public function getResult();
}