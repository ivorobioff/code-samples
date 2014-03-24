<?php
namespace UnitTests\Analyzes\Components\DataBuilder;

use Modules\Analyzes\Components\DataBuilder\Objects\Date;
use Modules\Analyzes\Components\DataBuilder\Objects\DateService;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class DateServiceTest extends \PHPUnit_Framework_TestCase
{
	public function testFakeDateWhenDateFromMore()
	{
		$service = new DateService(new Date('2013-05-01'),  new Date('2014-01-01'), new Date('2014-05-20'));

		$this->assertEquals('2013-01-01', $service->fakeFrom()->toString());
	}

	public function testFakeDateWhenDateFromLess()
	{
		$service = new DateService(new Date('2012-01-01'), new Date('2014-01-01'), new Date('2014-05-20'));

		$this->assertEquals('2012-01-01', $service->fakeFrom()->toString());
	}
} 