<?php

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ReCommand extends AbstractCommand
{
	function execute()
	{
		$device_id = $this->_message->getDeviceId();

		$model = new DeviceModel();

		if (!$model->exists($device_id))
		{
			echo "The device (".$device_id.") does not exist\n";
			return ;
		}

		$model->update($device_id);

		$init_command = new InitCommand($this->_client, $this->_message);
		$init_command->execute();

		echo "Device (".$device_id.") was successfully re-registered\n";
	}
}