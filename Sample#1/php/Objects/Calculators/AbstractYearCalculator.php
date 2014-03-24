<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Calculators;

use Extensions\ExcelFormulas\Formulas;
use Modules\Analyzes\Components\DataBuilder\Objects\Month;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
abstract class AbstractYearCalculator extends AbstractCalculator
{
	/**
	 * @return array
	 */
	abstract protected function _getMonths();

	public function getVolatilityPercentage()
	{
		return $this->getPriorQuarterAvg() / $this->_getAverage();
	}

	public function getPriorQuarterAvg()
	{
		$months = array_reverse($this->_getMonths());
		$values = array();
		$c = 0;

		/**
		 * @var Month $item
		 */
		foreach ($months as $item)
		{
			$c++;

			$values[] = $item->getCell()->getValue();

			if ($c == 3) break;
		}

		return $this->_stdev($values) * sqrt(count($values));
	}

	private function _getAverage()
	{
		$values = array();

		/**
		 * @var Month $month
		 */
		foreach ($this->_getMonths() as $month)
		{
			$values[] = $month->getCell()->getValue();
		}

		return array_sum($values) / count($values);
	}

	protected function _calcGrowth($y_values, $x_values, $value)
	{
		if (count(array_unique($y_values)) == 1) return $y_values[0];

		$formula = new Formulas();

		$res = $formula->calcGrowth($y_values, $x_values, array($value));

		return $res[0];
	}

	protected function _stdev(array $data)
	{
		return sqrt(array_sum(array_map(function($x, $mean){
			return pow($x - $mean,2);
		}, $data, array_fill(0,count($data), (array_sum($data) / count($data))))) / (count($data)-1));
	}
}