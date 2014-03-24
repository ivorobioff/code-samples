<?php
namespace UnitTests\Analyzes\Components\DataBuilder\Summary;
use Modules\Analyzes\Components\DataBuilder\Objects\Category;
use Modules\Analyzes\Components\DataBuilder\Objects\Summary\RawStorage;
use Modules\Analyzes\Components\DataBuilder\Objects\Summary\YearItem;
use Modules\Analyzes\Components\DataBuilder\Objects\Year;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class RawStorageTest extends \PHPUnit_Framework_TestCase
{
	public function testIterator()
	{
		$storage = new RawStorage();

		$cat_data = array(
			(object) array('name' => 'Test1')
		);

		$storage->addYearItem(new YearItem(new Year(2012), new Category($cat_data)));
		$storage->addYearItem(new YearItem(new Year(2012), new Category($cat_data)));
		$storage->addYearItem(new YearItem(new Year(2013), new Category($cat_data)));
		$storage->addYearItem(new YearItem(new Year(2014), new Category($cat_data)));
		$storage->addYearItem(new YearItem(new Year(2011), new Category($cat_data)));
		$storage->addYearItem(new YearItem(new Year(2015), new Category($cat_data)));
		$storage->addYearItem(new YearItem(new Year(2015), new Category($cat_data)));

		$res = iterator_to_array($storage);

		$this->assertEquals(array(2011, 2012, 2013, 2014, 2015), array_keys($res));
	}
} 