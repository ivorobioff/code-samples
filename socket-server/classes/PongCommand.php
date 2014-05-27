<?php

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class PongCommand extends AbstractCommand
{
	function execute()
	{
		$device_id = $this->_message->getDeviceId();
		$my_device_id = $this->_client->getMetaData()->device_id;

		if ($my_device_id != $device_id)
		{
			echo "Wrong device! My device is (".$my_device_id."), but received (".$device_id.") \n";
			return ;
		}

		$model = new DeviceModel();
		$model->setOnline($my_device_id);

		$this->_client->getMetaData()->online = MetaData::STATUS_ONLINE;

		$this->_client->getPing()->reset();
		$this->_client->getPing()->getTimer()->start();
		echo "Pong received from (".$this->_client->getConnection().")\n";
	}
}