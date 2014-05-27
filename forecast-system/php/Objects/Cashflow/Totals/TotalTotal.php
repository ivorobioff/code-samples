<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Totals;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class TotalTotal extends AbstractTotal
{
	/**
	 * @var CashTotal
	 */
	private $_cash_total;

	/**
	 * @var ExpensesTotal
	 */
	private $_expenses_total;

	/**
	 * @var SalesTotal
	 */
	private $_sales_total;

	public function getTotal()
	{
		$cash_total = $this->_cash_total->getTotal();
		$sales_total = $this->_sales_total->getTotal();
		$expenses_total =  $this->_expenses_total->getTotal();

		return ($cash_total + $sales_total) - $expenses_total;
	}

	public function getText()
	{
		return $this->_months->bottom()->getTotalCell()->getLabel()->getText();
	}

	public function setCashTotal(CashTotal $total)
	{
		$this->_cash_total = $total;
	}

	public function setExpensesTotal(ExpensesTotal $total)
	{
		$this->_expenses_total = $total;
	}

	public function setSalesTotal(SalesTotal $sales)
	{
		$this->_sales_total = $sales;
	}
}