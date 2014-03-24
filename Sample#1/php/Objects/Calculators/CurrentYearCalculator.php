<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Calculators;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class CurrentYearCalculator extends AbstractYearCalculator
{
	protected function _getMonths()
	{
		return $this->_year->getActualMonths()->toArray();
	}

	public function getGrowth($value)
	{
		$y_values = $this->_year->getMonthsBefore($value)->getCellValues();
		$x_values = $this->_year->getMonthsBefore($value)->getValues();

		return $this->_calcGrowth($y_values, $x_values, $value);
	}
}