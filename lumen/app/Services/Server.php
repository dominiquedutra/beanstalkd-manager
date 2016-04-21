<?php

namespace App\Services;

use Pheanstalk\Pheanstalk;

class Server
{
	function __construct($serverIp='127.0.0.1', $serverPort='11300')
	{
		$this->server = new Pheanstalk($serverIp, $serverPort);
	}

	/**
	 * Probe a beanstalkd server
	 * using pheanstalk class
	 * 
	 * @param  string $serverIp
	 * @param  string $serverPort
	 * @return boolean
	 */
	public function probeServer()
	{
		return $this->server->getConnection()->isServiceListening();
	}

	/**
	 * List the existing tubes on ths server
	 * 
	 * @return array
	 */
	public function listTubes()
	{
		return $this->server->listTubes();
	}

	/**
	 * Pass everything else directly to pheanstalk
	 * 
	 * @param  string $method Method being called
	 * @param  array $args   Arguments being passed
	 * @return void
	 */
	public function __call ($method, $args)
	{
		return $this->server->$method(...$args);
	}	
}