<?php namespace Pintu;

class ServerJson implements ServerInterface {

	const INBOX = 'inbox.json';
	const OUTBOX = 'outbox.json';

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * Constructor
	 */
	public function __construct($path = '')
	{
		if (is_dir($path) && is_writable($path)) {
			$this->path = $path;
		} else {
			throw new \InvalidArgumentException($path.' is not valid directory');
		}
	}

	public function getStatus()
	{
		return is_file($this->path(self::INBOX)) || is_file($this->path(self::OUTBOX));
	}
	

	public function readInbox()
	{
		$result = $this->getStandardResult();

		if (is_file($this->path(self::INBOX))) {
			$result = $this->getFoundResult(self::INBOX);
		}

		return $result;
	}
	

	public function saveInbox($data = array())
	{
		$data = (array) json_decode($data);
		$result = $this->getStandardResult();

		if (isset($data['from']) && isset($data['message']))
		{
			$payload = array();

			if (is_file($this->path(self::INBOX))) {
				$payload = $this->read(self::INBOX);
			}

			$payload[] = array(
				'from' => $data['from'],
				'message' => $data['message'],
				'date' => time(),
			);

			$result = $this->getCreatedResult(self::INBOX, $payload);
		}

		return $result;
	}
	

	public function readOutbox()
	{
		$result = $this->getStandardResult();

		if (is_file($this->path(self::OUTBOX))) {
			$result = $this->getFoundResult(self::OUTBOX);
		}

		return $result;
	}
	

	public function saveOutbox($data)
	{
		$data = (array) json_decode($data);
		$result = $this->getStandardResult();

		if (isset($data['to']) && isset($data['message']))
		{
			$payload = array();

			if (is_file($this->path(self::OUTBOX))) {
				$payload = $this->read(self::OUTBOX);
			}

			$payload[] = array(
				'to' => $data['to'],
				'message' => $data['message'],
				'date' => time(),
			);

			$result = $this->getCreatedResult(self::OUTBOX, $payload);
		}

		return $result;
	}

	protected function getStandardResult()
	{
		$result = new \stdClass();
		$result->status = 404;
		$result->data = json_encode(array('message' => 'none'));

		return $result;
	}

	protected function getFoundResult($type = self::INBOX)
	{
		$data = $this->read($type);
		$result = new \stdClass();
		$result->status = 200;
		$result->data = json_encode($data);

		return $result;
	}

	protected function getCreatedResult($type = self::INBOX, $data)
	{
		$this->write($type, $data);

		$result = new \stdClass();
		$result->status = 201;
		$result->data = json_encode($data);

		return $result;
	}

	protected function path($type = self::INBOX)
	{
		return realpath($this->path).DIRECTORY_SEPARATOR.$type;
	}

	protected function read($type = self::INBOX)
	{
		return json_decode(file_get_contents($this->path($type)));
	}

	protected function write($type = self::INBOX, $data)
	{
		return file_put_contents($this->path($type), json_encode($data));
	}

}