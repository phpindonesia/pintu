<?php namespace Pintu;

interface ServerInterface {

	public function getStatus();
	

	public function readInbox();
	

	public function saveInbox($data);
	

	public function readOutbox();
	

	public function saveOutbox($data);

}