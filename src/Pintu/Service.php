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

		foreach ($this->command->all() as $command => $flag) {
			fprintf($stream, "$command\r\n");

			$flag == true and $this->wait_for_ok($stream);
		}

		fclose($stream);
	}
	/**
	 * Waits for OK to be sent back by the modem.
	 *
	 * @param resource $f
	 */
	protected function get_string($f) {
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
			echo "> $response\n";
		} while ($response != "OK");
	}
}