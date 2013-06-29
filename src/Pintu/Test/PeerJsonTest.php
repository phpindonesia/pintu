<?php namespace Pintu\Test;

use Pintu\PeerInterface;
use Pintu\PeerJson;

class PeerJsonTest extends \PHPUnit_Framework_TestCase 
{
	protected $peer;

	public function testPeerListen()
	{
		$peer = new PeerJson('http://sms.phpindonesia.net/');

		$this->assertInstanceOf('\Pintu\PeerJson', $peer);

		$peer->listen();
	}
}