<?php
namespace UnitTests\Analyzes\Components\DataBuilder;

use Modules\Analyzes\Components\DataBuilder\Objects\CategoriesIterator;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class CategoriesIteratorTest extends \PHPUnit_Framework_TestCase
{
	public function testGroupByCategories()
	{
		$iterator = new CategoriesIterator(array(
			(object) array('name' => 'Test1'),
			(object) array('name' => 'Test2'),
			(object) array('name' => 'Test1'),
			(object) array('name' => 'Test2'),
			(object) array('name' => 'Test1'),
			(object) array('name' => 'Test2'),
			(object) array('name' => 'Test2'),
			(object) array('name' => 'Test3'),
		));

		$cats = iterator_to_array($iterator);

		$this->assertEquals(3, $this->_countGroupedData($cats, 'Test1'));
		$this->assertEquals(4, $this->_countGroupedData($cats, 'Test2'));
		$this->assertEquals(1, $this->_countGroupedData($cats, 'Test3'));
	}

	private function _countGroupedData($cats, $cat_name)
	{
		$cat = $cats[md5($cat_name)];
		$ref = new \ReflectionObject($cat);
		$ref = $ref->getProperty('_data');
		$ref->setAccessible(true);

		return count($ref->getValue($cat));
	}
} 