<?php

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Timer 
{
	private $_start_timestamp = 0;
	private $_limit_sec;

	public function __construct($limit_sec)
	{
		$this->_limit_sec = $limit_sec;
	}

	public function isExpired()
	{
		return (time() - $this->_start_timestamp) >= $this->_limit_sec;
	}

	public function start()
	{
		$this->_start_timestamp = time();
	}
} 