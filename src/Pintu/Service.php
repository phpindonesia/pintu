<?php namespace Pintu;

class Service implements DIOServiceInterface
{
	/**
	 * @var DIOSessionInterface
	 */
	protected $session;

	/**
	 * @var ATCommandInterface
	 */
	protected $command;

	/**
	* @var array
	*/
	protected $result;
	

	/**
	 * Constructor
	 *
	 * @param DIOSessionInterface
	 * @param ATCommandInterface
	 */
	public function __construct(DIOSessionInterface $session, ATCommandInterface $command)
	{
		$this->session = $session;
		$this->command = $command;
	}

	/**
	 * Main API
	 */
	public function run()
	{
		$stream = $this->session->getStream();

		stream_set_blocking($stream, true);

		foreach ($this->command->all() as $item) {
			$command = $item[ATCommandInterface::EXE];
			$wait = $item[ATCommandInterface::WAIT_FOR_OK];
			$escaped = $item[ATCommandInterface::ESCAPE];

			fprintf($stream, "$command\r\n");

			if ($escaped) fprintf($stream, chr(26));
			
			if ($wait) $this->wait_for_ok($stream);
		}

		fclose($stream);
	}

	/**
	 * Run and get the array result
	 */
	public function getResult()
	{
		$this->run();
		
		return $this->result;
	}

	/**
	 * Waits for OK to be sent back by the modem.
	 *
	 * @param resource $f
	 */
	protected function get_string($f) {
		$response = '';

		do {
			// remove carriage returns, line feeds and excess white space
			$response = trim(str_replace(array("\r\n","\r","\n"), '', fgets($f)));
		} while ($response == '');
	 
		return $response;
	}
	 
	/**
	 * Waits for OK to be sent back by the modem.
	 *
	 * @param resource $f
	 */
	protected function wait_for_ok($f) {
		$response = "";
		do {
			$response = $this->get_string($f);
			$this->result[] = $response;
		} while ($response != "OK");
	}

}