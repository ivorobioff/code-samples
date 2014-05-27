<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cashflow;

use Modules\Analyzes\Components\DataBuilder\Objects\Range\MonthRange;
use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Cells\CashCell;
use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Cells\LocalStorageCell;
use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Cells\TotalCell;
use Modules\Analyzes\Components\DataBuilder\Objects\Summary\YearTotals;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class MonthsMaker extends \IteratorIterator
{
	/**
	 * @var LabelsProvider
	 */
	private $_labels_provider;
	private $_prior_month;

	/**
	 * @var YearTotals
	 */
	private $_expenses_summary;

	/**
	 * @var YearTotals
	 */
	private $_sales_summary;

	private $_init_budget_amount;

	public function __construct(array $months, Month $last_month = null)
	{
		parent::__construct(new \ArrayIterator($months));
		$this->_prior_month = $last_month;
	}

	public function current()
	{
		/**
		 * @var MonthRange $month_range
		 */
		$month_range = parent::current();
		$month = new Month($month_range->getValue());

		$label = $this->_labels_provider->getCashLabel();

		$init_amount = $month_range->isFirstFuture() ? $this->_init_budget_amount : null;

		$month->setCashCell(new CashCell($label, $init_amount));

		$label = $this->_labels_provider->getExpensesLabel();
		$total = $this->_getLocalStorageTotal($this->_expenses_summary, $month_range->getValue());
		$month->setExpensesCell(new LocalStorageCell($total, $label));

		$label = $this->_labels_provider->getSalesLabel();
		$total = $this->_getLocalStorageTotal($this->_sales_summary, $month_range->getValue());
		$month->setSalesCell(new LocalStorageCell($total, $label));

		$label = $this->_labels_provider->getTotalLabel();
		$month->setTotalCell(new TotalCell($label));

		if (!is_null($this->_prior_month)) $month->setPriorMonth($this->_prior_month);
		$this->_prior_month = $month;

		return $month;
	}

	private function _getLocalStorageTotal(YearTotals $totals, $month)
	{
		if (is_null($totals)) return 0;

		$month_totals = $totals->findMonthTotals($month);

		if (is_null($month_totals)) return 0;

		return $month_totals->getTotal();
	}

	public function setLabelsProvider(LabelsProvider $labels_provider)
	{
		$this->_labels_provider = $labels_provider;
	}

	public function setExpensesSummary(YearTotals $summary = null)
	{
		$this->_expenses_summary = $summary;
	}

	public function setSalesSummary(YearTotals $year_summary = null)
	{
		$this->_sales_summary = $year_summary;
	}

	public function setInitBudgetAmount($amount)
	{
		$this->_init_budget_amount = $amount;
	}
} 