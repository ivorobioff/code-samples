<?php
namespace UnitTests\Analyzes\Components\DataBuilder;
use Modules\Analyzes\Components\DataBuilder\Objects\Category;
use Modules\Analyzes\Components\DataBuilder\Objects\Date;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class CategoryTest extends \PHPUnit_Framework_TestCase
{
	public function testGetValueByDate()
	{
		$cat = new Category(array(
			(object) array(
				'date' => '2014-01-21',
				'amount' => 10,
			),
			(object) array(
				'date' => '2014-01-10',
				'amount' => 10,
			),
			(object) array(
				'date' => '2014-01-15',
				'amount' => 10,
			),
			(object) array(
				'date' => '2014-05-02',
				'amount' => 10,
			),
			(object) array(
				'date' => '2014-05-21',
				'amount' => 10,
			),

			(object) array(
				'date' => '2015-09-21',
				'amount' => 10,
			),
			(object) array(
				'date' => '2015-10-10',
				'amount' => 10,
			),
			(object) array(
				'date' => '2015-11-21',
				'amount' => 10,
			),
		));

		$this->assertEquals(30, $cat->getValueByDate(new Date('2014-1')));
		$this->assertEquals(10, $cat->getValueByDate(new Date('2015-09')));
	}

	public function testGetName()
	{
		$cat = new Category(array(
			(object) array('name' => 'Test1'),
			(object) array('name' => 'Test1'),
			(object) array('name' => 'Test1'),
		));

		$this->assertEquals('Test1', $cat->getName());
	}
} 