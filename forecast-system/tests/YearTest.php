<?php
namespace UnitTests\Analyzes\Components\DataBuilder;

use Modules\Analyzes\Components\DataBuilder\Objects\Cells\ActualCell;
use Modules\Analyzes\Components\DataBuilder\Objects\Cells\NullCell;
use Modules\Analyzes\Components\DataBuilder\Objects\Month;
use Modules\Analyzes\Components\DataBuilder\Objects\Year;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class YearTest extends \PHPUnit_Framework_TestCase
{
	public function testGetMonthsBeforeAndStarting()
	{
		$year = new Year(2013);
		$year->addMonth(new Month(1, new ActualCell(100)));
		$year->addMonth(new Month(2, new ActualCell(100)));
		$year->addMonth(new Month(3, new ActualCell(100)));
		$year->addMonth(new Month(4, new ActualCell(100)));
		$year->addMonth(new Month(5, new ActualCell(100)));
		$year->addMonth(new Month(6, new ActualCell(100)));
		$year->addMonth(new Month(7, new ActualCell(100)));
		$year->addMonth(new Month(8, new ActualCell(100)));
		$year->addMonth(new Month(9, new ActualCell(100)));
		$year->addMonth(new Month(10, new ActualCell(100)));
		$year->addMonth(new Month(11, new ActualCell(100)));
		$year->addMonth(new Month(12, new ActualCell(100)));

		$this->assertEquals(array(1, 2, 3, 4, 5), $year->getMonthsBefore(6)->getValues());
		$this->assertEquals(array(6, 7, 8, 9, 10, 11, 12), $year->getMonthsStarting(6)->getValues());
	}

	public function testGetMonthsBeforeIfNoMonths()
	{
		$year = new Year(2013);

		$year->addMonth(new Month(5, new ActualCell(100)));
		$year->addMonth(new Month(6, new ActualCell(100)));
		$year->addMonth(new Month(7, new ActualCell(100)));
		$year->addMonth(new Month(8, new ActualCell(100)));
		$year->addMonth(new Month(9, new ActualCell(100)));
		$year->addMonth(new Month(10, new ActualCell(100)));
		$year->addMonth(new Month(11, new ActualCell(100)));
		$year->addMonth(new Month(12, new ActualCell(100)));

		$this->assertEquals(0, $year->getMonthsBefore(5)->getLength());
	}

	public function testGetMonthsStartingIfNoMonths()
	{
		$year = new Year(2013);

		$year->addMonth(new Month(1, new ActualCell(100)));
		$year->addMonth(new Month(2, new ActualCell(100)));
		$year->addMonth(new Month(3, new ActualCell(100)));
		$year->addMonth(new Month(4, new ActualCell(100)));
		$year->addMonth(new Month(5, new ActualCell(100)));
		$year->addMonth(new Month(6, new ActualCell(100)));

		$this->assertEquals(0, $year->getMonthsStarting(7)->getLength());
	}

	public function testGetMonthsBeforeAndStartingWithLessMonths()
	{
		$year = new Year(2013);

		$year->addMonth(new Month(8, new ActualCell(100)));
		$year->addMonth(new Month(9, new ActualCell(100)));
		$year->addMonth(new Month(10, new ActualCell(100)));
		$year->addMonth(new Month(11, new ActualCell(100)));
		$year->addMonth(new Month(12, new ActualCell(100)));

		$this->assertEquals(array(8, 9, 10, 11, 12), $year->getMonthsStarting(6)->getValues());

		$year = new Year(2013);

		$year->addMonth(new Month(1, new ActualCell(100)));
		$year->addMonth(new Month(2, new ActualCell(100)));
		$year->addMonth(new Month(3, new ActualCell(100)));
		$year->addMonth(new Month(4, new ActualCell(100)));
		$year->addMonth(new Month(5, new ActualCell(100)));

		$this->assertEquals(array(1, 2, 3, 4, 5), $year->getMonthsBefore(9)->getValues());
	}

	public function testTryGetValue()
	{
		$year2013 = new Year(2013);
		$year2013->addMonth(new Month(1, new NullCell()));
		$year2013->addMonth(new Month(2, new NullCell()));
		$year2013->addMonth(new Month(3, new NullCell()));
		$year2013->addMonth(new Month(4, new NullCell()));
		$year2013->addMonth(new Month(5, new NullCell()));
		$year2013->addMonth(new Month(6, new NullCell()));
		$year2013->addMonth(new Month(7, new ActualCell(100)));
		$year2013->addMonth(new Month(8, new NullCell()));
		$year2013->addMonth(new Month(9, new NullCell()));
		$year2013->addMonth(new Month(10, new NullCell()));
		$year2013->addMonth(new Month(11, new NullCell()));
		$year2013->addMonth(new Month(12, new NullCell()));

		$year2014 = new Year(2014);

		$year2014->setPriorYear($year2013);
		$this->assertEquals(100, $year2014->tryGetValue(7));

		$year2013 = new Year(2013);
		$year2013->addMonth(new Month(12, new NullCell()));

		$year2014 = new Year(2014);

		$year2014->setPriorYear($year2013);
		$this->assertNull($year2014->tryGetValue(11));
	}
} 