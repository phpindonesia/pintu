<?php namespace Pintu;

use Guzzle\Http\Client;
use Pintu\ReaderArray;

class PeerJson implements PeerInterface {
	const INBOX = '/inbox';
	const OUTBOX = '/outbox';

	const QUEUE = '_queue';
	const DATA_INBOX = '_data_inbox';
	const DATA_OUTBOX = '_data_outbox';

	/**
	 * @var string
	 */
	protected $server;

	/**
	 * @var array
	 */
	protected $payload = array();

	/**
	 * @var array
	 */
	protected $archive = array();

	/**
	 * Constructor
	 *
	 * @param string Server endpoint
	 */
	public function __construct($server = '')
	{
		$client = new Client($server);
		$request = $client->get('/');
		$response = $request->send();

		if ($response->getStatusCode() == 200) {
			$this->server = $server;
		} else {
			throw new \InvalidArgumentException('Invalid server');
			
		}
	}

	/**
	 * Main API
	 */
	public function listen()
	{
		$this->payload = $this->archive = array(
			self::DATA_INBOX => array(),
			self::DATA_OUTBOX => array(),
		);

		$this->collectQueue();

		$this->collectPayload();
	}

	protected function collectQueue()
	{

		$inbox = $this->executeGet(self::INBOX);
		$outbox = $this->executeGet(self::OUTBOX);

		if ($inbox) {
			$inbox = (string) $inbox;
			list($head,$body) = explode("\n\r\n",$inbox);
			$this->archive[self::DATA_INBOX] = json_decode(json_decode($body),true);
		}

		if ($outbox) {
			$outbox = (string) $outbox;
			list($head,$body) = explode("\n\r\n",$outbox);
			$this->archive[self::DATA_OUTBOX] = json_decode(json_decode($body),true);
		}
	}

	protected function collectPayload()
	{
		$reader = new ReaderArray();
		$dsn = "dio.serial:///dev/ttyUSB2";

		$session = new Session($dsn);
		$command = new Command();

		$command->setSMSTextMode();
		$command->readSMS(ATCommandInterface::TYPE_ALL);

		$service = new Service($session, $command);

		$this->payload[self::DATA_INBOX] = $reader->get($service);
	}



	protected function executeGet($url) {
		$client = new Client($this->server);
		$request = $client->get($url);

		try {
			$response = $request->send();
		} catch (\Exception $e) {
			$response =false;
		}

		return $response;
	}

	protected function executePost($url, $data) {
		$client = new Client($this->server);
		$request = $client->post($url,array('Content-Type' => 'application/json'),$data);

		try {
			$response = $request->send();
		} catch (\Exception $e) {
			$response =false;
		}

		return $response;
	}

}
