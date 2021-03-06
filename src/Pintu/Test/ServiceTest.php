<?php namespace Pintu\Test;

use Pintu\Session;
use Pintu\Command;
use Pintu\Service;
use Pintu\ATCommandInterface;


class ServiceTest extends \PHPUnit_Framework_TestCase 
{
	public function testRunValidService()
	{
		$dsn = "dio.serial:///dev/ttyUSB0";

		$session = new Session($dsn);
		$command = new Command();

		$command->setSMSTextMode();
		$command->sendSMS('085648721439', 'Foo Bar');
		$command->readSMS(ATCommandInterface::TYPE_ALL);

		$service = new Service($session, $command);

		$this->assertInstanceOf('\Pintu\DIOServiceInterface', $service);

		$service->run();
	}
}