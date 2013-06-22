<?php namespace Pintu;

class Session implements DIOSessionInterface
{
	/**
	 * @var string
	 */
	protected $dsn;

	/**
	 * @var resource
	 */
	protected $stream;

	/**
	 * Constructor
	 *
	 * @param $dsn The DSN to port/file
	 * @return DIOServiceInterface
	 * @throws InvalidArgumentException
	 */
	public function __construct($dsn = '') {
		$timeout = 30;

		do {
			$this->stream = @fopen($dsn, "r+", false, stream_context_create(array(
				'dio' => array(
					'data_rate' => 115200,
					'data_bits' => 8, 
					'stop_bits' => 1, 
					'parity' => 0, 
					'is_canonical' => 1)
				)
			));

			$timeout -= 1;
		} while ($timeout > 0 && empty($this->stream));

		if ( ! is_resource($this->stream)) {
			throw new \InvalidArgumentException('Cannot open file/port');
		}

		$this->dsn = $dsn;
	}

	/**
	 * Factory method to manufacturing session
	 *
	 * @param $dsn The DSN to port/file
	 * @return DIOServiceInterface
	 * @throws InvalidArgumentException
	 */
	public static function create($dsn = '') {
		return new static($dsn);
	}

	/**
	 * Get current DSN
	 *
	 * @return string
	 */
	public function getDsn() {
		return $this->dsn;
	}

	/**
	 * Get current stream
	 * 
	 * @return resource
	 */
	public function getStream() {
		return $this->stream;
	}

}