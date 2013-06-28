<?php namespace Pintu;

class ReaderArray implements ReaderInterface
{
	/**
	 * Parse the service into array
	 *
	 * @param Service
	 * @return array
	 */
	public function get(Service $service)
	{
		$result = array();
		$lines = $service->getResult();

		foreach ($lines as $index => $line) {
			if (strpos($line, self::IDENTIFIER) !== false) {
				$result[] = $this->parse($lines, $index);
			}
		}

		return $result;
	}

	/**
	 * Helper parser
	 *
	 * @param array 
	 * @param int
	 * @return array
	 */
	public function parse($lines = array(), $foundIndex = 0) {
		// Get the found line
		$line = $lines[$foundIndex];

		// Strip identifier
		$line = str_replace(self::IDENTIFIER, '', $line);

		// Get each element info
		list($id,$type,$number,$name,$date,$time) = explode(',', $line);

		if (strpos($time, '+') !== false) list($time, $s) = explode('+', $time);

		list($year,$month,$date) = explode('/', $date);

		$timestamp = strtotime('20'.trim($year,'"').'-'.$month.'-'.$date.' '.$time);

		$message = $lines[$foundIndex+1];

		// compact all elements
		$item = compact('id', 'type', 'number', 'name', 'timestamp','message');

		return array_map(function ($var)
		{
			return trim($var, '"');
		},$item);
	}


}