<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects;

use Modules\Analyzes\Components\DataBuilder\Objects\Calculators\NullCalculator;
use Modules\Analyzes\Components\DataBuilder\Objects\Calculators\PriorYearCalculator;
use Modules\Analyzes\Components\DataBuilder\Objects\Calculators\CurrentYearCalculator;
use Modules\Analyzes\Components\DataBuilder\Objects\Cells\ActualCell;
use Modules\Analyzes\Components\DataBuilder\Objects\Cells\ForecastCell;
use Modules\Analyzes\Components\DataBuilder\Objects\Cells\NullCell;
use Modules\Analyzes\Components\DataBuilder\Objects\Range\YearRange;
use Modules\Analyzes\Components\DataBuilder\Objects\Range\MonthRange;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class YearMaker extends \IteratorIterator
{
	/**
	 * @var Year
	 */
	private $_prior_year;

	/**
	 * @var Category
	 */
	private $_cat;

	private $_revise_by;

	/**
	 * @var OffsetDateFactory
	 */
	private $_date_factory;

	public function __construct(array $years, Category $cat)
	{
		parent::__construct(new \ArrayIterator($years));
		$this->_cat = $cat;
	}

	public function current()
	{
		/**
		 * @var YearRange $year_range
		 */
		$year_range = parent::current();

		$year = new Year($year_range->getValue());

		if ($this->_prior_year instanceof Year)
		{
			$year->setPriorYear($this->_prior_year);
		}

		/**
		 * @var MonthRange $month_range
		 */
		foreach ($year_range->getMonths() as $month_range)
		{
			if (!$month_range->isFuture())
			{
				$cat_date = new Date($year_range->getValue().'-'.$month_range->getValue());
				$cat_date = $this->_date_factory->shiftBack($cat_date);

				$date_value = $this->_cat->getValueByDate($cat_date);

				if ($date_value === 0) $date_value = 0.00001;

				$cell = !is_null($date_value) ? new ActualCell($date_value) : new NullCell();
			}
			else
			{
				$cell = new ForecastCell($this->_revise_by);
			}

			/**
			 * @var Month $month
			 */
			$month = new Month($month_range->getValue(), $cell);

			if ($month_range->isFake()) $month->setItsArranged();

			$year->addMonth($month);
		}

		if ($year->hasForecastMonth())
		{
			$year->setCalculator($this->_getCalculatorByYear($year));
		}

		$this->_prior_year = $year;
		return $year;
	}

	/**
	 * @param Year $year
	 * @return CurrentYearCalculator|NullCalculator|PriorYearCalculator
	 */
	private function _getCalculatorByYear(Year $year)
	{
		if ($year->hasPriorYear() && $year->getPriorYear()->countRealMonths() == 12) return new PriorYearCalculator();
		if ($year->countActualMonths() > 1) return new CurrentYearCalculator();
		if ($year->hasPriorYear() && $year->getPriorYear()->countActualMonths() > 1) return new PriorYearCalculator();

		return new NullCalculator();
	}

	/**
	 * @param int $value
	 */
	public function setReviseBy($value)
	{
		$this->_revise_by = $value;
	}

	/**
	 * @param OffsetDateFactory $factory
	 */
	public function setOffsetDateFactory(OffsetDateFactory $factory)
	{
		$this->_date_factory = $factory;
	}
} 