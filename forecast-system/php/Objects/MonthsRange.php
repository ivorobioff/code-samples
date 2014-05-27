<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class MonthsRange 
{
	private $_months = array();

	public function getValues()
	{
		$values = array();

		/**
		 * @var Month $month
		 */
		foreach ($this->_months as $month)
		{
			$values[] = $month->getValue();
		}

		return $values;
	}

	public function getCellValues()
	{
		$values = array();

		/**
		 * @var Month $month
		 */
		foreach ($this->_months as $month)
		{
			$values[] = $month->getCell()->getValue();
		}

		return $values;
	}

	public function getLength()
	{
		return count($this->_months);
	}

	public function addMonth(Month $month)
	{
		$this->_months[] = $month;
	}
} 