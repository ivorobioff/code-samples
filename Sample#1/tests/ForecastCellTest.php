<?php
namespace UnitTests\Analyzes\Components\DataBuilder;
use Modules\Analyzes\Components\DataBuilder\Objects\Cells\ForecastCell;
use Modules\Analyzes\Components\DataBuilder\Objects\Exceptions\ImpossibleCalculation;
use Modules\Analyzes\Components\DataBuilder\Objects\Month;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class ForecastCellTest extends \PHPUnit_Framework_TestCase
{
	public function testGetVelue()
	{
		$year = $this->_getYearMock(20, true);
		$cell = new ForecastCell();
		$month = new Month(1, $cell);
		$year->addMonth($month);

		$this->assertEquals(60, $cell->getValue());

		$year = $this->_getYearMock(10, true);
		$cell = new ForecastCell();
		$month = new Month(1, $cell);
		$year->addMonth($month);

		$this->assertEquals(-10, $cell->getValue());

		$year = $this->_getYearMock(15, true);
		$cell = new ForecastCell();
		$month = new Month(1, $cell);
		$year->addMonth($month);

		$this->assertEquals(15, $cell->getValue());
	}

	public function testGetVelueRevert()
	{
		$year = $this->_getYearMock(20, false);
		$cell = new ForecastCell();
		$month = new Month(1, $cell);
		$year->addMonth($month);

		$this->assertEquals(-20, $cell->getValue());

		$year = $this->_getYearMock(10, false);
		$cell = new ForecastCell();
		$month = new Month(1, $cell);
		$year->addMonth($month);

		$this->assertEquals(30, $cell->getValue());
	}

	public function testGetValueException()
	{
		$mock = $this->getMockBuilder('\Modules\Analyzes\Components\DataBuilder\Objects\Year')
			->setConstructorArgs(array(2013))
			->setMethods(array(
				'getVolatilityPercentage',
				'getPriorQuarterAvg',
				'getGrowth'))
			->getMock();

		$mock->expects($this->any())
			->method('getVolatilityPercentage')
			->will($this->throwException(new ImpossibleCalculation('getVolatilityPercentage')));

		$mock->expects($this->any())
			->method('getPriorQuarterAvg')
			->will($this->throwException(new ImpossibleCalculation('getPriorQuarterAvg')));

		$mock->expects($this->any())
			->method('getGrowth')
			->will($this->throwException(new ImpossibleCalculation('getGrowth')));

		$year = $mock;

		$cell = new ForecastCell();

		$month = new Month(1, $cell);
		$year->addMonth($month);

		$this->assertNull($cell->getValue());
	}

	public function testCacheValue()
	{
		$year = $this->_getYearMock(20, true);
		$cell = new ForecastCell();
		$month = new Month(1, $cell);
		$year->addMonth($month);

		$this->assertEquals(60, $cell->getValue());

		$ref = new \ReflectionObject($cell);
		$ref = $ref->getProperty('_cache_value');
		$ref->setAccessible(true);

		$this->assertEquals(60, $ref->getValue($cell));

		$ref->setValue($cell, 10);
		$this->assertEquals(10, $cell->getValue());
	}

	private function _getYearMock($growth, $is_prior_year_calculation)
	{
		$mock = $this->getMockBuilder('\Modules\Analyzes\Components\DataBuilder\Objects\Year')
			->setConstructorArgs(array(2013))
			->setMethods(array(
				'getVolatilityPercentage',
				'getPriorQuarterAvg',
				'getGrowth',
				'isPriorYearCalculation'))
			->getMock();

		$mock->expects($this->any())
			->method('getVolatilityPercentage')
			->will($this->returnValue(4));

		$mock->expects($this->any())
			->method('getPriorQuarterAvg')
			->will($this->returnValue(15));

		$mock->expects($this->any())
			->method('getGrowth')
			->will($this->returnValue($growth));

		$mock->expects($this->any())
			->method('isPriorYearCalculation')
			->will($this->returnValue($is_prior_year_calculation));

		return $mock;
	}
} 