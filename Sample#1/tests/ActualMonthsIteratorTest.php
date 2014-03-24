<?php
namespace UnitTests\Analyzes\Components\DataBuilder;

use Modules\Analyzes\Components\DataBuilder\Objects\MonthsIterators\ActualMonthsIterator;
use Modules\Analyzes\Components\DataBuilder\Objects\Cells\ActualCell;
use Modules\Analyzes\Components\DataBuilder\Objects\Cells\ForecastCell;
use Modules\Analyzes\Components\DataBuilder\Objects\Month;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class ActualMonthsIteratorTest extends \PHPUnit_Framework_TestCase
{
	public function testIterator()
	{
		$iterator = new ActualMonthsIterator(new \ArrayIterator(array(
			new Month(1, new ActualCell(100)),
			new Month(2, new ActualCell(100)),
			new Month(3, new ActualCell(100)),
			new Month(4, new ActualCell(100)),
			new Month(5, new ActualCell(100)),
			new Month(6, new ForecastCell()),
			new Month(7, new ForecastCell()),
			new Month(8, new ForecastCell()),
			new Month(9, new ForecastCell()),
			new Month(10, new ForecastCell()),
			new Month(11, new ForecastCell()),
			new Month(12, new ForecastCell()),
		)));

		$this->assertEquals(5, $iterator->count());
		$this->assertEquals(5, $iterator->count());
	}
} 