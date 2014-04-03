<?php

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class Db
{
	static private $_instance;

	static public function instance()
	{
		if (is_null(self::$_instance))
		{
			self::$_instance = new \Mysqli('localhost', 'root', '1234', 'blogs');
		}

		return self::$_instance;
	}
} 