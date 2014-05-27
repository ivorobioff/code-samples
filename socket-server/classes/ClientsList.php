<?php

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ClientsList extends ArrayIterator
{
	private $_connections = array();

	public function getAllConnections()
	{
		return $this->_connections;
	}

	public function add(Client $client)
	{
		$that = $this;

		$client->onTerminate(function() use ($that, $client){
			$that->delete($client);
		});

		$this[(string) $client->getConnection()] = $client;
		$this->_connections[(string) $client->getConnection()] = $client->getConnection();
	}

	public function delete(Client $client)
	{
		unset($this[(string) $client->getConnection()]);
		unset($this->_connections[(string) $client->getConnection()]);
	}

	/**
	 * @var $conn
	 * @return Client
	 */
	public function findByConnection($conn)
	{
		return $this[(string) $conn];
	}
}