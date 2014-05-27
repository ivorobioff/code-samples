<?php

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class Captcha
{
	static public function update()
	{
		return $_SESSION['captcha'] = array(rand(1, 9), rand(1, 9));
	}

	static public function get()
	{
		return $_SESSION['captcha'];
	}
} 