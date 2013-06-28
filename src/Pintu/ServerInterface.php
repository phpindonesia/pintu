<?php namespace Pintu;

interface ServerInterface {

	public function getStatus();
	

	public function readInbox();
	

	public function saveInbox();
	

	public function readOutbox();
	

	public function saveOutbox();

}