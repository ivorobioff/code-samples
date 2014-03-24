<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Summary;

use Modules\Analyzes\Components\DataBuilder\Objects\Month;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class YearTotals
{
	private $_year_value;

	/**
	 * @var \SplDoublyLinkedList
	 */
	private $_years_items;

	private $_cache_months_totals;
	private $_cache_category_totals;

	public function __construct($year_value)
	{
		$this->_year_value = $year_value;
		$this->_years_items = new \SplDoublyLinkedList();
	}

	public function addYearItem(YearItem $year_item)
	{
		$this->_years_items->push($year_item);
	}

	public function getYearValue()
	{
		return $this->_year_value;
	}

	public function getByMonths()
	{
		if (!is_null($this->_cache_months_totals)) return $this->_cache_months_totals;

		$iterator = new \ArrayIterator();

		/**
		 * @var YearItem $year_item
		 */
		foreach ($this->_years_items as $year_item)
		{
			$year = $year_item->getYear();

			/**
			 * @var Month $month
			 */
			foreach ($year->getMonths() as $month)
			{
				if ($month->isArranged()) continue ;

				$month_value = $month->getValue();

				if (!isset($iterator[$month_value]))
				{
					$iterator[$month_value] = new MonthTotals($month_value);
				}

				$iterator[$month_value]->sumTotal($month->getCell()->getValue());
			}
		}

		$iterator->ksort();

		$this->_cache_months_totals = $iterator;

		return $iterator;
	}

	/**
	 * @param int
	 * @return MonthTotals|null
	 */
	public function findMonthTotals($month)
	{
		$month_totals = $this->getByMonths();

		if (!isset($month_totals[$month])) return null;
		return $month_totals[$month];
	}

	public function getByCategories()
	{
		if (!is_null($this->_cache_category_totals)) return $this->_cache_category_totals;

		$iterator = new \ArrayIterator();

		/**
		 * @var YearItem $year_item
		 */
		foreach ($this->_years_items as $year_item)
		{
			$category_name = $year_item->getCategory()->getName();
			$iterator[$category_name] = new CategoryTotals($category_name);

			/**
			 * @var Month $month
			 */
			foreach ($year_item->getYear()->getMonths() as $month)
			{
				if ($month->isArranged()) continue ;

				$iterator[$category_name]->sumTotal($month->getCell()->getValue());
			}
		}

		$iterator->uksort(function($k1, $k2){
			if (strnatcmp($k1, $k2) < 0) return -1;
			if (strnatcmp($k1, $k2) > 0) return 1;

			return 0;
		});

		$this->_cache_category_totals = $iterator;

		return $iterator;
	}

	public function isArranged()
	{
		/**
		 * @var YearItem $year
		 */
		foreach ($this->_years_items as $year)
		{
			if ($year->getYear()->isArranaged()) return true;
		}

		return false;
	}

	public function getTotal()
	{
		$months_totals = $this->getByMonths();

		$total = 0;

		/**
		 * @var MonthTotals $month_totals
		 */
		foreach ($months_totals as $month_totals)
		{
			$total += $month_totals->getTotal();
		}

		return $total;
	}
} 