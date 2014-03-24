<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cashflow;

use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Cells\CashCell;
use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Cells\LocalStorageCell;
use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Cells\TotalCell;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class Month 
{
	/**
	 * @var Month
	 */
	private $_prior_month;

	private $_cash_cell;
	private $_expenses_cell;
	private $_sales_cell;
	private $_total_cell;

	private $_month_value;

	public function __construct($month_value)
	{
		$this->_month_value = $month_value;
	}

	public function getMonthValue()
	{
		return $this->_month_value;
	}

	public function setPriorMonth(Month $prior_month)
	{
		$this->_prior_month = $prior_month;
	}

	/**
	 * @param CashCell $cash_cell
	 */
	public function setCashCell(CashCell $cash_cell)
	{
		$cash_cell->setMonth($this);
		$this->_cash_cell = $cash_cell;
	}

	/**
	 * @return CashCell
	 */
	public function getCashCell()
	{
		return $this->_cash_cell;
	}

	/**
	 * @param LocalStorageCell $expenses_cell
	 */
	public function setExpensesCell(LocalStorageCell $expenses_cell)
	{
		$expenses_cell->setMonth($this);
		$this->_expenses_cell = $expenses_cell;
	}

	/**
	 * @return LocalStorageCell
	 */
	public function getExpensesCell()
	{
		return $this->_expenses_cell;
	}

	/**
	 * @param LocalStorageCell $sales_cell
	 */
	public function setSalesCell(LocalStorageCell $sales_cell)
	{
		$sales_cell->setMonth($this);
		$this->_sales_cell = $sales_cell;
	}

	/**
	 * @return LocalStorageCell
	 */
	public function getSalesCell()
	{
		return $this->_sales_cell;
	}

	/**
	 * @param TotalCell $total_cell
	 */
	public function setTotalCell(TotalCell $total_cell)
	{
		$total_cell->setMonth($this);
		$this->_total_cell = $total_cell;
	}

	/**
	 * @return TotalCell
	 */
	public function getTotalCell()
	{
		return $this->_total_cell;
	}

	public function getPrevTotalValue()
	{
		if (is_null($this->_prior_month)) return 0;
		return $this->_prior_month->getTotalCell()->getValue();
	}

	public function getCells()
	{
		return array(
			$this->_cash_cell,
			$this->_expenses_cell,
			$this->_sales_cell,
			$this->_total_cell
		);
	}
} 