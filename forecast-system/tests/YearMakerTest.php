<?php
namespace UnitTests\Analyzes\Components\DataBuilder;

use Modules\Analyzes\Components\DataBuilder\Objects\Category;
use Modules\Analyzes\Components\DataBuilder\Objects\Date;
use Modules\Analyzes\Components\DataBuilder\Objects\OffsetDateFactory;
use Modules\Analyzes\Components\DataBuilder\Objects\Range\MonthRange;
use Modules\Analyzes\Components\DataBuilder\Objects\Range\YearRange;
use Modules\Analyzes\Components\DataBuilder\Objects\Year;
use Modules\Analyzes\Components\DataBuilder\Objects\YearMaker;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class YearMakerTest extends \PHPUnit_Framework_TestCase
{
	public function testFullPriorYear()
	{
		$maker = new YearMaker(
			$this->_getYearPeriodsList(array(2013, 2014, 2015), $this->_getNow()),
			$this->_getCatMock());

		$maker->setOffsetDateFactory(new OffsetDateFactory(0));

		$years = iterator_to_array($maker);

		$this->assertEquals(3, count($years), 'Asserts the number of years');
		$this->assertEquals(array(2013, 2014, 2015), array(
			$years[0]->getValue(),
			$years[1]->getValue(),
			$years[2]->getValue(),
		), 'Asserts the values of the years');

		$calc_namespace = $this->_getCalcNamespance();

		$this->assertNull($this->_getCalculator($years[0]));
		$this->assertInstanceOf($calc_namespace.'\PriorYearCalculator', $this->_getCalculator($years[1]));
		$this->assertInstanceOf($calc_namespace.'\PriorYearCalculator', $this->_getCalculator($years[2]));

		$months = $years[0]->getMonths();

		$this->assertInstanceOf($this->_getCellNamespace().'\ActualCell', $months[4]->getCell());
		$this->assertInstanceOf($this->_getCellNamespace().'\ActualCell', $months[10]->getCell());

		$months = $years[1]->getMonths();

		$this->assertInstanceOf($this->_getCellNamespace().'\ActualCell', $months[1]->getCell());
		$this->assertInstanceOf($this->_getCellNamespace().'\ActualCell', $months[2]->getCell());
		$this->assertInstanceOf($this->_getCellNamespace().'\ActualCell', $months[3]->getCell());
		$this->assertInstanceOf($this->_getCellNamespace().'\ActualCell', $months[4]->getCell());

		$this->assertInstanceOf($this->_getCellNamespace().'\ForecastCell', $months[5]->getCell());
		$this->assertInstanceOf($this->_getCellNamespace().'\ForecastCell', $months[6]->getCell());
		$this->assertInstanceOf($this->_getCellNamespace().'\ForecastCell', $months[7]->getCell());
		$this->assertInstanceOf($this->_getCellNamespace().'\ForecastCell', $months[8]->getCell());
		$this->assertInstanceOf($this->_getCellNamespace().'\ForecastCell', $months[9]->getCell());
		$this->assertInstanceOf($this->_getCellNamespace().'\ForecastCell', $months[10]->getCell());
		$this->assertInstanceOf($this->_getCellNamespace().'\ForecastCell', $months[11]->getCell());
		$this->assertInstanceOf($this->_getCellNamespace().'\ForecastCell', $months[12]->getCell());


		$months = $years[2]->getMonths();

		$this->assertInstanceOf($this->_getCellNamespace().'\ForecastCell', $months[4]->getCell());
		$this->assertInstanceOf($this->_getCellNamespace().'\ForecastCell', $months[10]->getCell());
	}

	public function testCurrentYearAndNoPriorYear()
	{
		$maker = new YearMaker(
			$this->_getYearPeriodsList(array(2014, 2015), $this->_getNow()),
			$this->_getCatMock());

		$maker->setOffsetDateFactory(new OffsetDateFactory(0));

		$years = iterator_to_array($maker);

		$this->assertEquals(2, count($years), 'Asserts the number of years');

		$this->assertEquals(array(2014, 2015), array(
			$years[0]->getValue(),
			$years[1]->getValue(),
		), 'Asserts the values of the years');

		$calc_namespace = $this->_getCalcNamespance();

		$this->assertInstanceOf($calc_namespace.'\CurrentYearCalculator', $this->_getCalculator($years[0]));
		$this->assertInstanceOf($calc_namespace.'\PriorYearCalculator', $this->_getCalculator($years[1]));

		$months = $years[0]->getMonths();

		$this->assertInstanceOf($this->_getCellNamespace().'\ActualCell', $months[4]->getCell());
		$this->assertInstanceOf($this->_getCellNamespace().'\ForecastCell', $months[10]->getCell());

		$months = $years[1]->getMonths();

		$this->assertInstanceOf($this->_getCellNamespace().'\ForecastCell', $months[4]->getCell());
		$this->assertInstanceOf($this->_getCellNamespace().'\ForecastCell', $months[10]->getCell());
	}

	public function testCurrentYearAndNotFullPriorYear()
	{
		$now = $this->_getNow();

		$years_list = $this->_getYearPeriodsList(array(2014, 2015), $now);
		$year_range = new YearRange(2013);

		$year_range->addMonth(new MonthRange(7));
		$year_range->addMonth(new MonthRange(8));
		$year_range->addMonth(new MonthRange(9));
		$year_range->addMonth(new MonthRange(10));
		$year_range->addMonth(new MonthRange(11));
		$year_range->addMonth(new MonthRange(12));

		array_unshift($years_list, $year_range);

		$maker = new YearMaker($years_list, $this->_getCatMock());
		$maker->setOffsetDateFactory(new OffsetDateFactory(0));

		$years = iterator_to_array($maker);

		$calc_namespace = $this->_getCalcNamespance();

		$this->assertNull($this->_getCalculator($years[0]));
		$this->assertInstanceOf($calc_namespace.'\CurrentYearCalculator',$this->_getCalculator($years[1]));
		$this->assertInstanceOf($calc_namespace.'\PriorYearCalculator', $this->_getCalculator($years[2]));

		$this->assertEquals(0, $years[0]->countActualMonths() - $years[0]->countRealMonths(),
			'Asserts the number of actual months in the prior year');

		$months = $years[1]->getMonths();

		$this->assertInstanceOf($this->_getCellNamespace().'\ActualCell', $months[4]->getCell());
		$this->assertInstanceOf($this->_getCellNamespace().'\ForecastCell', $months[10]->getCell());
	}

	public function testNotFullPriorYear()
	{
		$now = new Date('2014-02-04');

		$years_list = $this->_getYearPeriodsList(array(2014, 2015), $now);
		$year_range = new YearRange(2013);

		$year_range->addMonth(new MonthRange(7));
		$year_range->addMonth(new MonthRange(8));
		$year_range->addMonth(new MonthRange(9));
		$year_range->addMonth(new MonthRange(10));
		$year_range->addMonth(new MonthRange(11));
		$year_range->addMonth(new MonthRange(12));

		array_unshift($years_list, $year_range);

		$maker = new YearMaker($years_list, $this->_getCatMock());
		$maker->setOffsetDateFactory(new OffsetDateFactory(0));

		$years = iterator_to_array($maker);

		$calc_namespace = $this->_getCalcNamespance();

		$this->assertNull($this->_getCalculator($years[0]));
		$this->assertInstanceOf($calc_namespace.'\PriorYearCalculator', $this->_getCalculator($years[1]));
		$this->assertInstanceOf($calc_namespace.'\PriorYearCalculator', $this->_getCalculator($years[2]));

		$months = $years[1]->getMonths();

		$this->assertInstanceOf($this->_getCellNamespace().'\ActualCell', $months[1]->getCell());
		$this->assertInstanceOf($this->_getCellNamespace().'\ForecastCell', $months[2]->getCell());
		$this->assertInstanceOf($this->_getCellNamespace().'\ForecastCell', $months[7]->getCell());
	}

	public function testSingleCellPriorYear()
	{
		$now = new Date('2014-01-04');

		$years_list = $this->_getYearPeriodsList(array(2014, 2015), $now);
		$year_range = new YearRange(2013);

		$year_range->addMonth(new MonthRange(12));

		array_unshift($years_list, $year_range);

		$maker = new YearMaker($years_list, $this->_getCatMock());
		$maker->setOffsetDateFactory(new OffsetDateFactory(0));

		$years = iterator_to_array($maker);

		$calc_namespace = $this->_getCalcNamespance();

		$this->assertNull($this->_getCalculator($years[0]));
		$this->assertInstanceOf($calc_namespace.'\NullCalculator', $this->_getCalculator($years[1]));
		$this->assertInstanceOf($calc_namespace.'\PriorYearCalculator', $this->_getCalculator($years[2]));

		$months = $years[1]->getMonths();
		$this->assertInstanceOf($this->_getCellNamespace().'\ForecastCell', $months[1]->getCell());
	}

	public function testSingleCellCurrentYear()
	{
		$now = new Date('2014-02-04');

		$maker = new YearMaker($this->_getYearPeriodsList(array(2014, 2015), $now), $this->_getCatMock());
		$maker->setOffsetDateFactory(new OffsetDateFactory(0));

		$years = iterator_to_array($maker);

		$calc_namespace = $this->_getCalcNamespance();

		$this->assertInstanceOf($calc_namespace.'\NullCalculator', $this->_getCalculator($years[0]));
		$this->assertInstanceOf($calc_namespace.'\PriorYearCalculator',$this->_getCalculator( $years[1]));

		$months = $years[0]->getMonths();
		$this->assertInstanceOf($this->_getCellNamespace().'\ActualCell', $months[1]->getCell());
		$this->assertInstanceOf($this->_getCellNamespace().'\ForecastCell', $months[2]->getCell());
		$this->assertInstanceOf($this->_getCellNamespace().'\ForecastCell', $months[10]->getCell());
	}

	public function testSignleActualCellAndSingleForecastCell()
	{
		$year_range = new YearRange(2014);

		$year_range->addMonth(new MonthRange(8));

		$month = new MonthRange(9);
		$month->setItsFuture();
		$year_range->addMonth($month);

		$maker = new YearMaker(array($year_range), $this->_getCatMock());
		$maker->setOffsetDateFactory(new OffsetDateFactory(0));

		$years = iterator_to_array($maker);

		$calc_namespace = $this->_getCalcNamespance();
		$this->assertInstanceOf($calc_namespace.'\NullCalculator', $this->_getCalculator($years[0]));

		$this->assertEquals(2, $years[0]->countRealMonths());
		$this->assertEquals(1, $years[0]->countActualMonths());
	}

	public function testMissingCategoryData()
	{
		$year_range = new YearRange(2013);
		$year_range->addMonth(new MonthRange(8));
		$year_range->addMonth(new MonthRange(9));

		$cat = $this->getMockBuilder('\Modules\Analyzes\Components\DataBuilder\Objects\Category')
			->setConstructorArgs(array(array()))
			->getMock();

		$cat->expects($this->any())->method('getValueByDate')->will($this->returnValue(null));

		$maker = new YearMaker(array($year_range), $cat);
		$maker->setOffsetDateFactory(new OffsetDateFactory(0));

		$years = iterator_to_array($maker);

		$months = $years[0]->getMonths();

		$class = '\Modules\Analyzes\Components\DataBuilder\Objects\Cells\NullCell';

		$this->assertInstanceOf($class,  $months[8]->getCell());
		$this->assertInstanceOf($class,  $months[9]->getCell());
	}

	public function testPriorYearWithNullCell()
	{
		$cat = $this->getMockBuilder('\Modules\Analyzes\Components\DataBuilder\Objects\Category')
			->setConstructorArgs(array(array()))
			->getMock();

		$cat->expects($this->any())
			->method('getValueByDate')
			->will($this->returnCallback(function(Date $date){
				if ($date->getYear() == 2013 && $date->getMonth() == 6) return null;
				return 100;
			}));

		$maker = new YearMaker(
			$this->_getYearPeriodsList(array(2013, 2014), $this->_getNow()),
			$cat);
		$maker->setOffsetDateFactory(new OffsetDateFactory(0));

		$years = iterator_to_array($maker);

		$calc_namespace = $this->_getCalcNamespance();

		$this->assertInstanceOf($calc_namespace.'\CurrentYearCalculator', $this->_getCalculator($years[1]));
	}

	public function testCurrentYearWithNullCell()
	{
		$cat = $this->getMockBuilder('\Modules\Analyzes\Components\DataBuilder\Objects\Category')
			->setConstructorArgs(array(array()))
			->getMock();

		$cat->expects($this->any())
			->method('getValueByDate')
			->will($this->returnCallback(function(Date $date){
				if ($date->getYear() == 2013 && $date->getMonth() == 1) return null;
				if ($date->getYear() == 2014 && in_array($date->getMonth(), array(2, 3, 4))) return null;
				return 100;
			}));

		$maker = new YearMaker(
			$this->_getYearPeriodsList(array(2013, 2014), $this->_getNow()),
			$cat);
		$maker->setOffsetDateFactory(new OffsetDateFactory(0));

		$years = iterator_to_array($maker);

		$calc_namespace = $this->_getCalcNamespance();

		$this->assertInstanceOf($calc_namespace.'\PriorYearCalculator', $this->_getCalculator($years[1]));
	}


	private function _getYearPeriodsList(array $years, Date $now)
	{
		foreach ($years as $year)
		{
			$year_range = new YearRange($year);

			for ($i = 1; $i <=12; $i ++)
			{
				$month = new MonthRange($i);

				if (($year == $now->getYear() && $i >= $now->getMonth()) || $year > $now->getYear())
				{
					$month->setItsFuture();
				}

				$year_range->addMonth($month);
			}


			$res[] = $year_range;
		}

		return $res;
	}

	/**
	 * @return Category
	 */
	private function _getCatMock()
	{
		$mock = $this->getMockBuilder('\Modules\Analyzes\Components\DataBuilder\Objects\Category')
			->setConstructorArgs(array(array()))
			->getMock();

		$mock->expects($this->any())->method('getValueByDate')->will($this->returnValue(100));
		return $mock;
	}

	private function _getCalcNamespance()
	{
		return '\Modules\Analyzes\Components\DataBuilder\Objects\Calculators';
	}

	private function _getCalculator(Year $year)
	{
		$ref = new \ReflectionObject($year);
		$ref = $ref->getProperty('_calc');
		$ref->setAccessible(true);

		return $ref->getValue($year);
	}

	private function _getCellNamespace()
	{
		return '\Modules\Analyzes\Components\DataBuilder\Objects\Cells';
	}

	private function _getNow()
	{
		return new Date('2014-05-04');
	}
} 