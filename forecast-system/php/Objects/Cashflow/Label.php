<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cashflow;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class Label 
{
	private $_text;
	private $_id;

	public function __construct($id, $text)
	{
		$this->_id = $id;
		$this->_text = $text;
	}

	public function getText()
	{
		return $this->_text;
	}

	public function getId()
	{
		return $this->_id;
	}
} 