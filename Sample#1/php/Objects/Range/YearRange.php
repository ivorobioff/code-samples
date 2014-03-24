<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Range;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class YearRange
{
	private $_value;
	private $_months;

	public function __construct($value)
	{
		$this->_value = $value;
	}

	public function getMonths()
	{
		return $this->_months;
	}

	public function getValue()
	{
		return $this->_value;
	}

	public function addMonth(MonthRange $month)
	{
		$month->setYear($this);
		$this->_months[$month->getValue()] = $month;
	}
} 