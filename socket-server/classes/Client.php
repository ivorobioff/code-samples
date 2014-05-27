<?php

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Client 
{
	private $_conn;
	private $_meta_data;
	private $_ping;

	private $_on_terminate;

	public function __construct($conn)
	{
		$this->_conn = $conn;
	}

	public function getConnection()
	{
		return $this->_conn;
	}

	/**
	 * @return MetaData
	 */
	public function getMetaData()
	{
		return $this->_meta_data;
	}

	public function setMetaData(MetaData $data)
	{
		$this->_meta_data = $data;
	}

	/**
	 * @return Ping
	 */
	public function getPing()
	{
		return $this->_ping;
	}

	public function hasPing()
	{
		return !is_null($this->_ping);
	}

	public function setPing(Ping $ping)
	{
		$this->_ping = $ping;
		$ping->getTimer()->start();
	}

	public function executeCommand(ClientMessage $message)
	{
		if (!$message->isValid()) throw new InvalidArgumentException();

		$commands_factory = new CommandsFactory();
		$commands_factory->create($this, $message)->execute();
	}

	public function terminate()
	{
		$command = new TerminateCommand($this);
		$command->execute();

		call_user_func($this->_on_terminate);
	}

	public function onTerminate(Closure $handler)
	{
		$this->_on_terminate = $handler;
	}
} 