<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cells;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class ActualCell extends AbstractCell
{
	private $_value;

	public function __construct($value)
	{
		$this->_value = $value;
	}

	public function getValue()
	{
		return $this->_value;
	}
} 