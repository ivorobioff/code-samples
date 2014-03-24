<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Calculators;

use Modules\Analyzes\Components\DataBuilder\Objects\Exceptions\ImpossibleCalculation;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class NullCalculator extends AbstractCalculator
{
	public function getVolatilityPercentage()
	{
		throw new ImpossibleCalculation(__METHOD__);
	}

	public function getPriorQuarterAvg()
	{
		throw new ImpossibleCalculation(__METHOD__);
	}

	public function getGrowth($value)
	{
		throw new ImpossibleCalculation(__METHOD__);
	}
} 