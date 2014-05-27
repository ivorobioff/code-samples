<?php

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Ping 
{
	const STATUS_READY = 0;
	const STATUS_PENDING = 1;

	private $_client;

	private $_timer;
	private $_pending_timer;

	private $_current_try = 0;
	private $_status;

	public function __construct(Client $client)
	{
		$this->_client = $client;

		$this->_timer = new Timer(30);
		$this->_pending_timer = new Timer(10);
	}

	public function execute()
	{
		$command = new PingCommand($this->_client);
		$command->execute();
	}

	public function getTimer()
	{
		return $this->_timer;
	}

	public function getPendingTimer()
	{
		return $this->_pending_timer;
	}

	public function isFinalTry()
	{
		return $this->_current_try == 3;
	}

	public function nextTry()
	{
		$this->_current_try ++;
	}

	public function getStatus()
	{
		return $this->_status;
	}

	public function setStatus($status)
	{
		$this->_status = $status;
	}

	public function reset()
	{
		$this->setStatus(Ping::STATUS_READY);
		$this->_current_try = 0;
	}
} 