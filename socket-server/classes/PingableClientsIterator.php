<?php
/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class PingableClientsIterator extends FilterIterator
{
	public function accept()
	{
		/**
		 * @var Client $client
		 */
		$client = $this->current();

		if (!$client->hasPing()) return false;

		$ping = $client->getPing();

		if (!$ping->getTimer()->isExpired()) return false;

		if ($ping->getStatus() == Ping::STATUS_PENDING)
		{
			if (!$ping->getPendingTimer()->isExpired()) return false;

			if ($client->getMetaData()->online == MetaData::STATUS_ONLINE)
			{
				$model = new DeviceModel();
				$model->setOffline($client->getMetaData()->device_id);
				
				$client->getMetaData()->online = MetaData::STATUS_OFFLINE;
			}

			if ($ping->isFinalTry())
			{
				$client->terminate();
				return false;
			}

			$ping->nextTry();
			$ping->getPendingTimer()->start();

			return false;
		}

		return true;
	}
}