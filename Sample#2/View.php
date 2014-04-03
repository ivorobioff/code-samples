<?php
/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class View 
{
	private $_template;
	private $_vars = array();
	static private $_global_vars = array();

	public function __construct($template)
	{
		$this->_template = trim($template, '/');
	}

	static public function create($template)
	{
		return new static($template);
	}

	public function assign($var_name, $value)
	{
		$this->_vars[$var_name] = $value;
		return $this;
	}

	static public function assignGlobal($var_name, $value)
	{
		self::$_global_vars[$var_name] = $value;
	}

	public function render($show_now = true)
	{
		ob_start();
		include __DIR__.'/views/'.$this->_template;
		$output = ob_get_clean();

		if (!$show_now)
		{
			return $output;
		}

		echo $output;
	}

	public function __get($var_name)
	{
		if (isset($this->_vars[$var_name])) return $this->_vars[$var_name];
		return self::$_global_vars[$var_name];
	}

	public function __isset($var_name)
	{
		if (isset($this->_vars[$var_name])) return true;
		if (isset(self::$_global_vars[$var_name])) return true;

		return false;
	}

	static public function formatText($text)
	{
		$regex_url = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

		if(preg_match($regex_url, $text, $url))
		{
			$text = preg_replace($regex_url, '<a target="_blank" href="'.$url[0].'">'.$url[0].'</a>', $text);
		}

		return nl2br($text);
	}

	static public function escape($str)
	{
		return htmlspecialchars($str);
	}
} 