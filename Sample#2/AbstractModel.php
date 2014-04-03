<?php

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
abstract class AbstractModel
{
	private $_data;
	private $_id;

	public function __construct(array $data = null)
	{
		$this->_data = $data;
	}

	static public function create(array $data)
	{
		$data['insert_date'] = date('Y-m-d H:i:s');
		return new static($data);
	}

	public function toArray()
	{
		$data = $this->_data;
		$data['id'] = $this->_id;
		return $data;
	}

	public function save()
	{
		$this->validate($this->_data);
		$this->_id = $this->add($this->_data);
	}

	abstract public function validate(array $data);
	abstract public function add(array $data);
} 