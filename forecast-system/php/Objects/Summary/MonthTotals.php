<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Summary;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class MonthTotals
{
	private $_total = 0;

	private $_month_value;

	public function __construct($month_value)
	{
		$this->_month_value = $month_value;
	}

	public function sumTotal($num)
	{
		if (is_null($num)) return ;

		$this->_total += $num;
	}

	public function getTotal()
	{
		return $this->_total;
	}

	public function getMonthValue()
	{
		return $this->_month_value;
	}
} 