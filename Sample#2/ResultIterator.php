<?php

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class ResultIterator implements Iterator, Countable
{
	private $_res;
	private $_item;
	private $_counter = 0;

	public function __construct(mysqli_result $res)
	{
		$this->_res = $res;
	}

	public function current()
	{
		return $this->_item;
	}

	public function next()
	{
		$this->_item = $this->_res->fetch_assoc();

		if (!$this->_item) $this->_res->free();

		$this->_counter ++;
	}

	public function key()
	{
		return $this->_counter;
	}

	public function valid()
	{
		return (bool) $this->_item;
	}

	public function rewind()
	{
		$this->_item = $this->_res->fetch_assoc();
	}

	public function count()
	{
		return $this->_res->num_rows;
	}
}