<?php

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class RegisterCommand extends AbstractCommand
{
	function execute()
	{
		$device_id = $this->_message->getDeviceId();

		$model = new DeviceModel();

		if ($model->exists($device_id))
		{
			echo "The device (".$device_id.") is already registered\n";
			return ;
		}

		$model->add($device_id);

		$init_command = new InitCommand($this->_client, $this->_message);
		$init_command->execute();

		echo "Device (".$device_id.") was registered successfully\n";
	}
}