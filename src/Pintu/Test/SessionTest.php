<?php namespace Pintu\Test;

use Pintu\Session;

class SessionTest extends \PHPUnit_Framework_TestCase 
{

	public function testInitializeInvalidPort()
	{
		$dsn = "dio.serial:///dev/ttyUSB5";

		$this->setExpectedException('InvalidArgumentException', 'Cannot open file/port');

		$session = new Session($dsn);
	}

	public function testInitializeValidPort()
	{
		$dsn = "dio.serial:///dev/ttyUSB2";

		$session = Session::create($dsn);

		$this->assertInstanceOf('\Pintu\DIOSessionInterface', $session);

		$this->assertEquals($dsn, $session->getDsn());

		$this->assertTrue(is_resource($session->getStream()));
	}

}