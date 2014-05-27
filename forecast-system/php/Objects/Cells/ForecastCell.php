<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cells;

use Modules\Analyzes\Components\DataBuilder\Objects\Exceptions\ImpossibleCalculation;
use Modules\Analyzes\Components\DataBuilder\Objects\Year;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class ForecastCell extends AbstractCell
{
	private $_cache_value = false;

	private $_revise_by;

	public function __construct($revise_by = 0)
	{
		$this->_revise_by = $revise_by;
	}

	public function getValue()
	{
		if ($this->_cache_value === false)
		{
			$value = $this->_getValue();

			if (!is_null($value))
			{
				$value += $value * $this->_revise_by / 100;
			}

			$this->_cache_value = $value;
		}

		return $this->_cache_value;
	}

	private function _getValue()
	{
		try
		{
			/**
			 * @var Year $year
			 */
			$year = $this->_month->getYear();

			$revert = 1;

			if ($year->isPriorYearCalculation())  $revert = -1;

			$growth = $year->getGrowth($this->_month->getValue());

			if ($growth > $year->getPriorQuarterAvg())
			{
				return (1 + ($revert * (-0.5) * $year->getVolatilityPercentage())) * $growth;
			}

			if ($growth < $year->getPriorQuarterAvg())
			{
				return (1 + ($revert * 0.5 * $year->getVolatilityPercentage())) * $growth;
			}

			return $growth;
		}
		catch (ImpossibleCalculation $ex)
		{
			return $this->_month->getYear()->tryGetValue($this->_month->getValue());
		}
	}
} 
