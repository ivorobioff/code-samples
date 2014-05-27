<?php

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DeviceModel
{
	public function exists($id)
	{
		$res = Db::instance()->query('
			SELECT * FROM devices
			WHERE device_id = "'.Db::instance()->real_escape_string($id).'"
		');

		return $res->num_rows > 0;
	}

	public function get($id)
	{
		$res = Db::instance()->query('
			SELECT * FROM devices
			WHERE device_id = "'.Db::instance()->real_escape_string($id).'"
			LIMIT 1
		');

		return $res->fetch_assoc();
	}

	public function getAll()
	{
		$data = array();
		$res = Db::instance()->query('SELECT * FROM devices');

		while ($row = $res->fetch_assoc())
		{
			$data[] = $row;
		}

		return $data;
	}

	public function add($id)
	{
		Db::instance()->query('
			INSERT INTO devices (`device_id`, `online`, `last_seen`)
			VALUES(	"'.Db::instance()->real_escape_string($id).'", 1, '.time().')
		');
	}

	public function update($id)
	{
		Db::instance()->query('
			UPDATE devices SET `online`=1, `last_seen`='.time().'
			WHERE device_id="'.Db::instance()->real_escape_string($id).'"
		');
	}

	public function setOnline($id)
	{
		Db::instance()->query('
			UPDATE devices
			SET last_seen='.time().', online=1
			WHERE device_id="'.Db::instance()->real_escape_string($id).'"'
		);
	}

	public function setOffline($id)
	{
		Db::instance()->query('
			UPDATE devices
			SET online=0
			WHERE device_id="'.Db::instance()->real_escape_string($id).'"'
		);
	}
} 