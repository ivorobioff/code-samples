<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Cells;
use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Label;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class LocalStorageCell extends AbstractCell
{
	private $_value;

	/**
	 * @param float $value
	 * @param Label $label
	 */
	public function __construct($value, Label $label)
	{
		parent::__construct($label);
		$this->_value = $value;
	}

	public function getValue()
	{
		return $this->_value;
	}
} 