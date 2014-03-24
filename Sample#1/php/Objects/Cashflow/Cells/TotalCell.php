<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Cells;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class TotalCell extends AbstractCell
{
	private $_cache_value;

	public function getValue()
	{
		if (is_null($this->_cache_value))
		{
			throw new \LogicException('Call '.__CLASS__.'::fixValue() first.');
		}

		return $this->_cache_value;
	}

	/**
	 * The method is made for the optimization purposes.
	 * To avoid a long recursion.
	 */
	public function fixValue()
	{
		$cash = $this->_month->getCashCell()->getValue();
		$expenses = $this->_month->getExpensesCell()->getValue();
		$sales = $this->_month->getSalesCell()->getValue();

		$this->_cache_value = ($cash + $sales) - $expenses;
	}
}