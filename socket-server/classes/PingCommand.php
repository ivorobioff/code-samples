<?php

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class PingCommand extends AbstractCommand
{
	function execute()
	{
		$conn = $this->_client->getConnection();
		fwrite($conn, 'ping '.$this->_client->getMetaData()->device_id);

		$this->_client->getPing()->setStatus(Ping::STATUS_PENDING);
		$this->_client->getPing()->getPendingTimer()->start();

		echo "Ping sent to (".$this->_client->getConnection().")\n";
	}
}