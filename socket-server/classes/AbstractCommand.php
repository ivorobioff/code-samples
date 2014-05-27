<?php

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractCommand
{
	/**
	 * @var Client
	 */
	protected $_client;
	protected $_message;

	public function __construct(Client $client, ClientMessage $message = null)
	{
		$this->_client = $client;
		$this->_message = $message;
	}

	abstract function execute();
} 