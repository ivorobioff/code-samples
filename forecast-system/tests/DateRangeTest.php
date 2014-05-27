<?php
namespace UnitTests\Analyzes\Components\DataBuilder;
use Modules\Analyzes\Components\DataBuilder\Objects\Date;
use Modules\Analyzes\Components\DataBuilder\Objects\DateService;
use Modules\Analyzes\Components\DataBuilder\Objects\Range\DateRange;
use Modules\Analyzes\Components\DataBuilder\Objects\Range\YearRange;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class DateRangeTest extends \PHPUnit_Framework_TestCase
{
	public function testGetYears()
	{
		$date_service = new DateService(new Date('2013-01-31'), new Date('2015-12-31'), new Date('2014-05-14'));

		$range = new DateRange($date_service, new Date('2013-06-01'));
		$years = $range->getYears();

		$this->assertEquals(3, count($years));
		$this->assertEquals(array(2013, 2014, 2015), array(
			$years[2013]->getValue(),
			$years[2014]->getValue(),
			$years[2015]->getValue(),
		));

		$months = $years[2013]->getMonths();
		$this->assertEquals(7, count($months));
		$this->assertEquals(6, $months[6]->getValue());
		$this->assertEquals(12, $months[12]->getValue());

		$months = $years[2014]->getMonths();
		$this->assertEquals(12, count($months));
		$this->assertTrue($months[5]->isFuture());
		$this->assertFalse($months[4]->isFuture());

		$months = $years[2015]->getMonths();
		$this->assertEquals(12, count($months));
		$this->assertTrue($months[1]->isFuture());
	}


	public function testIsFake()
	{
		$date_service = new DateService(new Date('2013-05-01'), new Date('2013-12-31'), new Date('2013-05-14'));

		$range = new DateRange($date_service, new Date('2013-01-01'));

		$year = $range->getYears();
		/**
		 * @var YearRange $year
		 */
		$year = $year[2013];
		$months = $year->getMonths();

		$this->assertEquals(
			array(true, true, true, true, false),
			array(
				$months[1]->isFake(),
				$months[2]->isFake(),
				$months[3]->isFake(),
				$months[4]->isFake(),
				$months[5]->isFake())
		);
	}

	public function testIsFirstFuture()
	{
		$date_service = new DateService(new Date('2013-03-01'), new Date('2013-12-31'), new Date('2013-05-14'));

		$range = new DateRange($date_service);

		$year = $range->getYears();
		/**
		 * @var YearRange $year
		 */
		$year = $year[2013];
		$months = $year->getMonths();

		$this->assertEquals(
			array(false, false, true, false, false),
			array(
				$months[3]->isFirstFuture(),
				$months[4]->isFirstFuture(),
				$months[5]->isFirstFuture(),
				$months[6]->isFirstFuture(),
				$months[7]->isFirstFuture())
		);
	}
} 