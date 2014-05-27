<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cashflow;

use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Totals\CashTotal;
use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Totals\ExpensesTotal;
use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Totals\SalesTotal;
use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Totals\TotalTotal;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class Sheet 
{
	private $_year_value;

	private $_months;

	public function __construct($year_value)
	{
		$this->_year_value = $year_value;
		$this->_months = new \SplDoublyLinkedList();
	}

	public function getYearValue()
	{
		return $this->_year_value;
	}

	public function addMonth(Month $month)
	{
		$month->getTotalCell()->fixValue();
		$this->_months->push($month);
	}

	public function getMonths()
	{
		return $this->_months;
	}

	public function getTotalByLabels()
	{
		$totals = new \SplDoublyLinkedList();

		$cash_total = new CashTotal($this->_months);
		$expenses_total = new ExpensesTotal($this->_months);
		$sales_total = new SalesTotal($this->_months);

		$totals->push($cash_total);
		$totals->push($expenses_total);
		$totals->push($sales_total);

		$total_total = new TotalTotal($this->_months);

		$total_total->setCashTotal($cash_total);
		$total_total->setExpensesTotal($expenses_total);
		$total_total->setSalesTotal($sales_total);

		$totals->push($total_total);

		return $totals;
	}
} 