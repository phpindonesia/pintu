<?php namespace Pintu\Test;

use Pintu\Command;
use Pintu\ATCommandInterface;

class CommandTest extends \PHPUnit_Framework_TestCase 
{
	public function testSetSMSTextMode() 
	{
		$command = new Command();

		$this->assertInstanceOf('\Pintu\ATCommandInterface', $command);

		$command->setSMSTextMode();

		$this->assertCount(1, $command->all());
	}

	public function testSendSMS()
	{
		$command = new Command();
		$command->sendSMS('123', 'Some Message');

		// Get the commands
		$commands = $command->all();

		$this->assertCount(2, $commands);
		$this->assertEquals('AT+CMGS="123"', $commands[0][ATCommandInterface::EXE]);
		$this->assertEquals('Some Message', $commands[1][ATCommandInterface::EXE]);
	}
}