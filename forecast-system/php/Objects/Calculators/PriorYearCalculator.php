<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Calculators;

use Modules\Analyzes\Components\DataBuilder\Objects\Exceptions\ImpossibleCalculation;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class PriorYearCalculator extends AbstractYearCalculator
{
	protected function _getMonths()
	{
		return $this->_year->getPriorYear()->getRealMonths()->toArray();
	}

	public function getGrowth($value)
	{
		if (!$this->_year->getPriorYear()->hasRealMonth($value))
		{
			throw new ImpossibleCalculation(__METHOD__);
		}

		$y_values = $this->_year->getPriorYear()->getMonthsStarting($value)->getCellValues();
		$x_values = $this->_year->getPriorYear()->getMonthsStarting($value)->getValues();

		return $this->_calcGrowth($y_values, $x_values, $value);
	}
}