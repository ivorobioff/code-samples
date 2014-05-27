<?php
namespace UnitTests\Analyzes\Components\DataBuilder;
use Modules\Analyzes\Components\DataBuilder\Objects\Range\MonthRange;
use Modules\Analyzes\Components\DataBuilder\Objects\Range\YearRange;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class YearRangeTest extends \PHPUnit_Framework_TestCase
{
	public function testAddMonth()
	{
		$year = new YearRange(2011);
		$month = new MonthRange(3);
		$year->addMonth($month);

		$ref = new \ReflectionObject($month);
		$ref = $ref->getProperty('_year');
		$ref->setAccessible(true);

		$this->assertEquals(2011, $ref->getValue($month)->getValue());
	}
} 