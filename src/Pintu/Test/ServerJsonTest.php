<?php namespace Pintu\Test;

use Pintu\ServerInterface;
use Pintu\ServerJson;

class ServerJsonTest extends \PHPUnit_Framework_TestCase 
{
	protected $server;

	public function setUp()
	{
		$this->server = new ServerJson(DATA_PATH);
	}

	public function testSaveOutbox()
	{
		$this->assertInstanceOf('\Pintu\ServerInterface', $this->server);
		$result = $this->server->saveOutbox(array(
			'to' => '109',
			'message' => 'Help!',
		));

		$this->assertEquals(201, $result->status);
	}

	public function testSaveInbox()
	{
		$this->assertInstanceOf('\Pintu\ServerInterface', $this->server);
		$result = $this->server->saveInbox(array(
			'from' => '109',
			'message' => 'OK FINE!',
		));

		$this->assertEquals(201, $result->status);
	}

	public function testGetStatus()
	{
		$this->assertInstanceOf('\Pintu\ServerInterface', $this->server);
		$this->assertTrue($this->server->getStatus());
	}

	public function testReadInbox()
	{
		$this->assertInstanceOf('\Pintu\ServerInterface', $this->server);
		$result = $this->server->readInbox();

		$this->assertEquals(200, $result->status);
	}

	public function testReadOutbox()
	{
		$this->assertInstanceOf('\Pintu\ServerInterface', $this->server);
		$result = $this->server->readInbox();

		$this->assertEquals(200, $result->status);
	}
}