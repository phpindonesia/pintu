<?php namespace Pintu;

interface ATCommandInterface
{
	const EXE = 'exe';
	const WAIT_FOR_OK = 'wait_for_ok';
	const ESCAPE = 'escape';

	const TYPE_ALL = 'ALL';
	const TYPE_OLD = 'REC READ';
	const TYPE_NEW = 'REC UNREAD';

	/**
	 * Return AT commands that need to be executed
	 *
	 * @return array
	 */
	public function all();
}