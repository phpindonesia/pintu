<?php namespace Pintu\Test;

use Pintu\Command;

class CommandTest extends \PHPUnit_Framework_TestCase 
{
	public function testSetSMSTextMode() 
	{
		$command = new Command();

		$this->assertInstanceOf('\Pintu\ATCommandInterface', $command);

		$command->setSMSTextMode();

		$this->assertEquals('AT+CMGF=1', key($command->all()));
	}

	public function testSendSMS()
	{
		$command = new Command();
		$command->sendSMS('123', 'Some Message');

		// Get the commands
		$commands = $command->all();

		$this->assertCount(2, $commands);
		$this->assertEquals('AT+CMGS="123"', key($commands));
		next($commands);
		$this->assertEquals('Some Message', key($commands));
	}
}