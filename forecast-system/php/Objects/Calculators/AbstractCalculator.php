<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Calculators;

use Modules\Analyzes\Components\DataBuilder\Objects\Year;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
abstract class AbstractCalculator
{
	/**
	 * @var Year
	 */
	protected $_year;

	abstract public function getVolatilityPercentage();
	abstract public function getPriorQuarterAvg();
	abstract public function getGrowth($value);

	public function setYear(Year $year)
	{
		$this->_year = $year;
	}
} 