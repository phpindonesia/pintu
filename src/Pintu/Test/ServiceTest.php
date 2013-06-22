<?php namespace Pintu\Test;

use Pintu\Session;
use Pintu\Command;
use Pintu\Service;

class ServiceTest extends \PHPUnit_Framework_TestCase 
{
	public function testRunValidService()
	{
		$dsn = "dio.serial:///dev/ttyUSB2";

		$session = new Session($dsn);
		$command = new Command();

		$command->setSMSTextMode();
		$command->sendSMS('085648721439', 'Foo Bar');

		$service = new Service($session, $command);

		$this->assertInstanceOf('\Pintu\DIOServiceInterface', $service);

		$service->run();
	}
}