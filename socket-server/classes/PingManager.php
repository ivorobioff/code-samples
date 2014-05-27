<?php

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class PingManager 
{
	public function run(ClientsList $clients)
	{
		$iterator = new PingableClientsIterator($clients);

		/**
		 * @var Client[] $iterator
		 */
		foreach ($iterator as $client)
		{
			$client->getPing()->execute();
		}
	}
} 