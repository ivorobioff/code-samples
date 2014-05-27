<?php

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class InitCommand extends AbstractCommand
{
	function execute()
	{
		$data = new MetaData();

		$data->device_id = $this->_message->getDeviceId();
		$data->online = MetaData::STATUS_ONLINE;

		$this->_client->setMetaData($data);

		$ping = new Ping($this->_client);
		$ping->getTimer()->start();

		$this->_client->setPing($ping);
	}
}