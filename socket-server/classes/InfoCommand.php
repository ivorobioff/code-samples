<?php

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class InfoCommand extends AbstractCommand
{
	function execute()
	{
		$model = new DeviceModel();
		$res = $model->get($this->_message->getDeviceId());

		if (!$res)
		{
			$message = 'Can\'t find the requested device';
		}
		else
		{
			$online = $res['online'] ? 'Yes' : 'No';
			$last_seen = $res['last_seen'];

			$message = 'device info for ('.$res['device_id'].'): Online = '.$online.', Last seen = '.$last_seen;
		}

		fwrite($this->_client->getConnection(), $message);
	}
}