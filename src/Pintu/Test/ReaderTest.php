<?php namespace Pintu\Test;

use Pintu\ReaderArray;
use Pintu\Session;
use Pintu\Command;
use Pintu\Service;
use Pintu\ATCommandInterface;

class ReaderTest extends \PHPUnit_Framework_TestCase 
{
	public function testRead()
	{
		$reader = new ReaderArray();

		$this->assertInstanceOf('\Pintu\ReaderInterface', $reader);

		$dsn = "dio.serial:///dev/ttyUSB0";

		$session = new Session($dsn);
		$command = new Command();

		$command->setSMSTextMode();
		$command->readSMS(ATCommandInterface::TYPE_ALL);

		$service = new Service($session, $command);

		$this->assertTrue(is_array($reader->get($service)));
	}
}