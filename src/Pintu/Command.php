<?php namespace Pintu;

class Command implements ATCommandInterface
{
	/**
	 * @var array
	 */
	protected $commands = array();

	/**
	 * Constructor
	 * 
	 * @param array $commands
	 */
	public function __construct($commands = array())
	{
		$this->commands = $commands;
	}

	/**
	 * Get all commands
	 *
	 * @return array
	 */
	public function all()
	{
		return $this->commands;
	}

	/**
	 * Register a command
	 *
	 * @param string The command
	 * @param boolean flag for CTRL-Z
	 * @param boolean flag for wait 
	 */
	public function register($command = '', $escaped = false, $wait = false)
	{
		$this->commands[] = array(
			self::EXE => $command,
			self::ESCAPE => $escaped,
			self::WAIT_FOR_OK => $wait,
		);
	}

	/**
	 * Set SMS Text Mode
	 */
	public function setSMSTextMode()
	{
		$this->register('AT+CMGF=1', false, true);
	}

	/**
	 * Send SMS
	 *
	 * This is the main API for sending SMS
	 *
	 * @param string $phone_num
	 * @param string $message
	 */
	public function sendSMS($phone_num = '', $message = '')
	{
		$this->register('AT+CMGS="'.$phone_num.'"', false, false);
		$this->register($message, true, true);
	}

	/**
	 * Read SMS
	 *
	 * This is the main API for reading SMS
	 *
	 */
	public function readSMS($type)
	{
		$this->register('AT+CMGL="'.$type.'"', true, true);
	}
}