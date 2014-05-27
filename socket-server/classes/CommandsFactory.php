<?php

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CommandsFactory 
{
	private $_commands_map = array(
		Constants::CMD_REGISTER => 'RegisterCommand',
		Constants::CMD_RE_REGISTER => 'ReCommand',
		Constants::CMD_INF0 => 'InfoCommand',
		Constants::CMD_PONG => 'PongCommand',
	);

	/**
	 * @param Client $client
	 * @param ClientMessage $message
	 * @return AbstractCommand
	 */
	public function create(Client $client, ClientMessage $message)
	{
		$class = $this->_commands_map[$message->getActionName()];
		return new $class($client, $message);
	}
} 