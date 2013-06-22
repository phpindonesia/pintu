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
	 * Set SMS Text Mode
	 */
	public function setSMSTextMode()
	{
		$this->commands['AT+CMGF=1'] = true;
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
		$this->commands['AT+CMGS="'.$phone_num.'"'] = false;
		$this->commands[$message] = true;
	}
}