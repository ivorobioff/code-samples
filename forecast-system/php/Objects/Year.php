<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects;

use Modules\Analyzes\Components\DataBuilder\Objects\Calculators\AbstractCalculator;
use Modules\Analyzes\Components\DataBuilder\Objects\Calculators\PriorYearCalculator;
use Modules\Analyzes\Components\DataBuilder\Objects\Cells\ForecastCell;
use Modules\Analyzes\Components\DataBuilder\Objects\Cells\NullCell;
use Modules\Analyzes\Components\DataBuilder\Objects\MonthsIterators\ActualMonthsIterator;
use Modules\Analyzes\Components\DataBuilder\Objects\MonthsIterators\RealMonthsIterator;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class Year 
{
	private $_value;
	/**
	 * @var AbstractCalculator
	 */
	private $_calc;

	private $_prior_year;

	private $_months = array();

	public function __construct($value)
	{
		$this->_value = $value;
	}

	public function getValue()
	{
		return $this->_value;
	}

	public function setCalculator(AbstractCalculator $calc)
	{
		$calc->setYear($this);
		$this->_calc = $calc;
	}

	public function setPriorYear(Year $year)
	{
		$this->_prior_year = $year;
	}

	/**
	 * @return Year
	 */
	public function getPriorYear()
	{
		return $this->_prior_year;
	}

	public function hasPriorYear()
	{
		return $this->_prior_year !== null;
	}

	public function countActualMonths()
	{
		$iterator = new ActualMonthsIterator(new \ArrayIterator($this->_months));
		return $iterator->count();
	}

	public function getActualMonths()
	{
		return new ActualMonthsIterator(new \ArrayIterator($this->_months));
	}

	public function countRealMonths()
	{
		return $this->getRealMonths()->count();
	}

	public function hasForecastMonth()
	{
		foreach ($this->_months as $month)
		{
			if ($month->getCell() instanceof ForecastCell) return true;
		}

		return false;
	}

	public function addMonth(Month $month)
	{
		$month->setYear($this);
		$this->_months[$month->getValue()] = $month;
	}

	/**
	 * @return RealMonthsIterator
	 */
	public function getRealMonths()
	{
		return new RealMonthsIterator(new \ArrayIterator($this->_months));
	}

	public function getMonths()
	{
		return $this->_months;
	}

	public function getVolatilityPercentage()
	{
		return $this->_calc->getVolatilityPercentage();
	}

	public function getPriorQuarterAvg()
	{
		return $this->_calc->getPriorQuarterAvg();
	}

	public function getGrowth($value)
	{
		return $this->_calc->getGrowth($value);
	}

	public function getMonthsBefore($value)
	{
		$range = new MonthsRange();

		/**
		 * @var Month $month
		 */
		foreach ($this->getRealMonths() as $month)
		{
			if ($month->getValue() >= $value) break;

			$range->addMonth($month);
		}

		return $range;
	}

	public function getMonthsStarting($value)
	{
		$range = new MonthsRange();

		/**
		 * @var Month $month
		 */
		foreach ($this->getRealMonths() as $month)
		{
			if ($month->getValue() < $value) continue;

			$range->addMonth($month);
		}

		return $range;
	}

	public function hasRealMonth($value)
	{
		if (!isset($this->_months[$value])) return false;
		if ($this->_months[$value]->getCell() instanceof NullCell) return false;

		return true;
	}

	public function isPriorYearCalculation()
	{
		return  $this->_calc instanceof PriorYearCalculator;
	}

	/**
	 * @param $value
	 * @return Month
	 */
	public function findMonth($value)
	{
		return $this->_months[$value];
	}

	/**
	 * @param $month
	 * @return bool
	 */
	public function hasMonth($month)
	{
		return isset($this->_months[$month]);
	}

	/**
	 * @param $month
	 * @return null|float
	 */
	public function tryGetValue($month)
	{
		if (!$this->hasPriorYear()) return null;
		if (!$this->getPriorYear()->hasMonth($month)) return null;

		return $this->getPriorYear()->findMonth($month)->getCell()->getValue();
	}

	public function isArranaged()
	{
		/**
		 * @var Month $month
		 */
		foreach ($this->getMonths() as $month)
		{
			if (!$month->isArranged()) return false;
		}

		return true;
	}
}
