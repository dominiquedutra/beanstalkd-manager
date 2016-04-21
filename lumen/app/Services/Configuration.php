<?php

namespace App\Services;

use Pheanstalk\Pheanstalk;

class Configuration
{
	/**
	 * Easily clear all servers
	 * 
	 * @return boolean
	 */
	public function clearServers()
	{
		app('db')->table('servers')->truncate();
		return true;
	}

	/**
	 * Get the registered servers
	 * 
	 * @return array
	 */
	public function getServers()
	{
		return app('db')->select('select * from servers order by id desc');
	}

	/**
	 * Add a server
	 * 
	 * @param boolean
	 */
	public function addServer($server)
	{
		return app('db')->table('servers')->insert($server);
	}

	/**
	 * Remove a server by its id
	 * 
	 * @param  integer $serverId
	 * @return boolean
	 */
	public function removeServer($serverId)
	{
		return app('db')->table('servers')->where('id', $serverId)->delete();
	}
}