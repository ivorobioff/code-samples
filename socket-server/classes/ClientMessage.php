<?php
/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ClientMessage 
{
	private $_message;

	private $_avail_actions = array(
		Constants::CMD_REGISTER,
		Constants::CMD_RE_REGISTER,
		Constants::CMD_INF0,
		Constants::CMD_PONG
	);

	private $_cache_action_name;
	private $_cache_device_id;

	public function __construct($message)
	{
		$this->_message = $message;
	}

	public function getActionName()
	{
		if (is_null($this->_cache_action_name))
		{
			$cmd = substr($this->_message, 0, strrpos($this->_message, ' ') + 1);
			$this->_cache_action_name = trim($cmd);
		}
		return $this->_cache_action_name;
	}

	public function getDeviceId()
	{
		if (is_null($this->_cache_device_id))
		{
			$cmd = substr($this->_message, strrpos($this->_message, ' '));
			$this->_cache_device_id = trim($cmd);
		}
		return $this->_cache_device_id;
	}

	public function isValid()
	{
		if (trim($this->_message) == '') return false;
		if (!in_array($this->getActionName(), $this->_avail_actions)) return false;
		return true;
	}

	public function __toString()
	{
		return $this->_message;
	}
} 