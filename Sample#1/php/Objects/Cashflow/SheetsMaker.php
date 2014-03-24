<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cashflow;

use Modules\Analyzes\Components\DataBuilder\Objects\Range\YearRange;
use Modules\Analyzes\Components\DataBuilder\Objects\Summary\StorageTotals;


/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class SheetsMaker extends \IteratorIterator
{
	/**
	 * @var StorageTotals
	 */
	private $_expenses_summary;

	/**
	 * @var StorageTotals
	 */
	private $_sales_summary;

	private $_last_month;

	private $_params;

	public function __construct(array $years)
	{
		parent::__construct(new \ArrayIterator($years));
	}

	public function current()
	{
		/**
		 * @var YearRange $year_range
		 */
		$year_range = parent::current();

		$sheet = new Sheet($year_range->getValue());

		$months_maker = new MonthsMaker($year_range->getMonths(), $this->_last_month);

		$months_maker->setLabelsProvider(new LabelsProvider());
		$months_maker->setExpensesSummary($this->_expenses_summary->findByYear($year_range->getValue()));
		$months_maker->setSalesSummary($this->_sales_summary->findByYear($year_range->getValue()));
		$months_maker->setInitBudgetAmount($this->_params['starting_cashin']);

		foreach ($months_maker as $month)
		{
			$sheet->addMonth($month);
			$this->_last_month = $month;
		}

		return $sheet;
	}

	public function setExpensesSummary(StorageTotals $expenses_summary)
	{
		$this->_expenses_summary = $expenses_summary;
	}

	public function setSalesSummary(StorageTotals $sales_summary)
	{
		$this->_sales_summary = $sales_summary;
	}

	public function setParams(array $params)
	{
		$this->_params = $params;
	}
} 