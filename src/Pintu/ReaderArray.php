<?php namespace Pintu;

class ReaderArray implements ReaderInterface
{
	/**
	 * get the array
	 */
	public function get(Service $service)
	{
		$result = $service->getResult();
		return $result;
	}


}