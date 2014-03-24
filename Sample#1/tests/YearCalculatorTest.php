<?php
namespace UnitTests\Analyzes\Components\DataBuilder;

use Modules\Analyzes\Components\DataBuilder\Objects\Calculators\CurrentYearCalculator;
use Modules\Analyzes\Components\DataBuilder\Objects\Calculators\PriorYearCalculator;
use Modules\Analyzes\Components\DataBuilder\Objects\Cells\ActualCell;
use Modules\Analyzes\Components\DataBuilder\Objects\Cells\ForecastCell;
use Modules\Analyzes\Components\DataBuilder\Objects\Cells\NullCell;
use Modules\Analyzes\Components\DataBuilder\Objects\Month;
use Modules\Analyzes\Components\DataBuilder\Objects\Year;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class YearCalculatorTest extends \PHPUnit_Framework_TestCase
{
	public function testCurrentYearCalculator()
	{
		$year = new Year(2013);

		$year->addMonth(new Month(1, new ActualCell(20)));
		$year->addMonth(new Month(2, new ActualCell(50)));
		$year->addMonth(new Month(3, new ActualCell(100)));
		$year->addMonth(new Month(4, new ActualCell(10)));
		$year->addMonth(new Month(5, new ActualCell(80)));
		$year->addMonth(new Month(6, new ActualCell(40)));
		$year->addMonth(new Month(7, new ActualCell(70)));

		$year->addMonth(new Month(8, new ForecastCell()));
		$year->addMonth(new Month(9, new ForecastCell()));
		$year->addMonth(new Month(10, new ForecastCell()));
		$year->addMonth(new Month(11, new ForecastCell()));
		$year->addMonth(new Month(12, new ForecastCell()));


		$calc = new CurrentYearCalculator();
		$year->setCalculator($calc);

		$this->assertEquals(36.0555, round($calc->getPriorQuarterAvg(), 4));
		$this->assertEquals(0.6821, round($calc->getVolatilityPercentage(), 4));
		$this->assertEquals(65.0284, round($calc->getGrowth(8), 4));
	}

	public function testPriorYearCalculator()
	{
		$p_year = new Year(2013);

		$p_year->addMonth(new Month(1, new ActualCell(20)));
		$p_year->addMonth(new Month(2, new ActualCell(50)));
		$p_year->addMonth(new Month(3, new ActualCell(100)));
		$p_year->addMonth(new Month(4, new ActualCell(10)));
		$p_year->addMonth(new Month(5, new ActualCell(80)));
		$p_year->addMonth(new Month(6, new ActualCell(40)));
		$p_year->addMonth(new Month(7, new ActualCell(70)));
		$p_year->addMonth(new Month(8, new ActualCell(100)));
		$p_year->addMonth(new Month(9, new ActualCell(20)));
		$p_year->addMonth(new Month(10, new ActualCell(60)));
		$p_year->addMonth(new Month(11, new ActualCell(10)));
		$p_year->addMonth(new Month(12, new ActualCell(90)));

		$year = new Year(2014);
		$year->setPriorYear($p_year);

		$calc = new PriorYearCalculator();
		$year->setCalculator($calc);

		$this->assertEquals(70, round($calc->getPriorQuarterAvg(), 4));
		$this->assertEquals(1.2923, round($calc->getVolatilityPercentage(), 4));
		$this->assertEquals(48.4388, round($calc->getGrowth(8), 4));
	}

	public function testGetGrowthAllValuesEqual()
	{
		$p_year = new Year(2013);

		$p_year->addMonth(new Month(8, new ActualCell(10)));
		$p_year->addMonth(new Month(9, new ActualCell(10)));
		$p_year->addMonth(new Month(10, new ActualCell(10)));
		$p_year->addMonth(new Month(11, new ActualCell(10)));
		$p_year->addMonth(new Month(12, new ActualCell(10)));


		$year = new Year(2014);
		$year->setPriorYear($p_year);

		$calc = new PriorYearCalculator();
		$year->setCalculator($calc);

		$this->assertEquals(10, round($calc->getGrowth(8), 4));

		$year = new Year(2014);

		$year->addMonth(new Month(8, new ActualCell(10)));
		$year->addMonth(new Month(9, new ActualCell(10)));
		$year->addMonth(new Month(10, new ActualCell(10)));
		$year->addMonth(new Month(11, new ActualCell(10)));
		$year->addMonth(new Month(12, new ForecastCell()));

		$calc = new CurrentYearCalculator();
		$year->setCalculator($calc);

		$this->assertEquals(10, round($calc->getGrowth(12), 4));
	}

	/**
	 * @expectedException \Modules\Analyzes\Components\DataBuilder\Objects\Exceptions\ImpossibleCalculation
	 */
	public function testPriorYearException()
	{
		$p_year = new Year(2013);

		$p_year->addMonth(new Month(6, new ActualCell(40)));
		$p_year->addMonth(new Month(7, new ActualCell(70)));
		$p_year->addMonth(new Month(8, new ActualCell(100)));
		$p_year->addMonth(new Month(9, new ActualCell(20)));
		$p_year->addMonth(new Month(10, new ActualCell(60)));
		$p_year->addMonth(new Month(11, new ActualCell(10)));
		$p_year->addMonth(new Month(12, new ActualCell(90)));

		$year = new Year(2014);
		$year->setPriorYear($p_year);

		$calc = new PriorYearCalculator();
		$year->setCalculator($calc);

		$calc->getGrowth(5);
	}

	/**
	 * @expectedException \Modules\Analyzes\Components\DataBuilder\Objects\Exceptions\ImpossibleCalculation
	 */
	public function testPriorYearExceptionWithNullCell()
	{
		$p_year = new Year(2013);

		$p_year->addMonth(new Month(6, new ActualCell(40)));
		$p_year->addMonth(new Month(7, new ActualCell(70)));
		$p_year->addMonth(new Month(8, new NullCell()));
		$p_year->addMonth(new Month(9, new ActualCell(20)));
		$p_year->addMonth(new Month(10, new ActualCell(60)));
		$p_year->addMonth(new Month(11, new ActualCell(10)));
		$p_year->addMonth(new Month(12, new ActualCell(90)));

		$year = new Year(2014);
		$year->setPriorYear($p_year);

		$calc = new PriorYearCalculator();
		$year->setCalculator($calc);

		$calc->getGrowth(8);
	}

	public function testPriorYearCalculatorWithNullCell()
	{
		$p_year = new Year(2013);

		$p_year->addMonth(new Month(1, new ActualCell(20)));
		$p_year->addMonth(new Month(2, new ActualCell(50)));
		$p_year->addMonth(new Month(3, new ActualCell(100)));
		$p_year->addMonth(new Month(4, new ActualCell(10)));
		$p_year->addMonth(new Month(5, new ActualCell(80)));
		$p_year->addMonth(new Month(6, new ActualCell(40)));
		$p_year->addMonth(new Month(7, new ActualCell(70)));
		$p_year->addMonth(new Month(8, new ActualCell(100)));
		$p_year->addMonth(new Month(9, new ActualCell(20)));
		$p_year->addMonth(new Month(10, new ActualCell(60)));
		$p_year->addMonth(new Month(11, new NullCell()));
		$p_year->addMonth(new Month(12, new ActualCell(90)));

		$year = new Year(2014);
		$year->setPriorYear($p_year);

		$calc = new PriorYearCalculator();
		$year->setCalculator($calc);

		$this->assertEquals(60.8276, round($calc->getPriorQuarterAvg(), 4));

		$ref = new \ReflectionObject($calc);
		$ref = $ref->getMethod('_getAverage');
		$ref->setAccessible(true);

		$this->assertEquals(58.1818, round($ref->invoke($calc), 4));
	}

	public function testGrowthWithNullCell()
	{
		$p_year = new Year(2013);

		$p_year->addMonth(new Month(1, new ActualCell(20)));
		$p_year->addMonth(new Month(2, new ActualCell(50)));
		$p_year->addMonth(new Month(3, new ActualCell(100)));
		$p_year->addMonth(new Month(4, new ActualCell(10)));
		$p_year->addMonth(new Month(5, new NullCell()));
		$p_year->addMonth(new Month(6, new ActualCell(40)));
		$p_year->addMonth(new Month(7, new ActualCell(70)));
		$p_year->addMonth(new Month(8, new ActualCell(100)));
		$p_year->addMonth(new Month(9, new ActualCell(20)));
		$p_year->addMonth(new Month(10, new ActualCell(60)));
		$p_year->addMonth(new Month(11, new ActualCell(10)));
		$p_year->addMonth(new Month(12, new ActualCell(90)));

		$year = new Year(2014);
		$year->setPriorYear($p_year);

		$calc = new PriorYearCalculator();
		$year->setCalculator($calc);

		$this->assertEquals(61.3262, round($calc->getGrowth(7), 4));
	}
} 