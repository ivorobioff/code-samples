<?php
namespace UnitTests\Analyzes\Components\DataBuilder;

use Modules\Analyzes\Components\DataBuilder\Objects\Heap;
use Modules\Analyzes\Components\DataBuilder\Objects\ResultItem;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class HeapTest extends \PHPUnit_Framework_TestCase
{
	public function testHeapOrder()
	{
		$heap = new Heap(function(ResultItem $item){
			return $item->getYearValue().'-'.$item->getCategoryName().'-'.$item->getMonthValue();
		});

		for ($i = 2011; $i <= 2013; $i++)
		{
			for ($j = 1; $j <= 3; $j ++)
			{
				$heap->insert($this->_getResultItemMock(array($i, 'B', $j)));
			}

			for ($j = 1; $j <= 3; $j ++)
			{
				$heap->insert($this->_getResultItemMock(array($i, 'A', $j)));
			}

			for ($j = 1; $j <= 3; $j ++)
			{
				$heap->insert($this->_getResultItemMock(array($i, 'C', $j)));
			}
		}

		foreach ($heap as $item)
		{
			$result[] = $item->getYearValue().'-'.$item->getCategoryName().'-'.$item->getMonthValue();
		}

		$this->assertEquals(json_encode(array(
				'2011-A-1', '2011-A-2', '2011-A-3',
				'2011-B-1', '2011-B-2', '2011-B-3',
				'2011-C-1', '2011-C-2', '2011-C-3',

				'2012-A-1', '2012-A-2', '2012-A-3',
				'2012-B-1', '2012-B-2', '2012-B-3',
				'2012-C-1', '2012-C-2', '2012-C-3',

				'2013-A-1', '2013-A-2', '2013-A-3',
				'2013-B-1', '2013-B-2', '2013-B-3',
				'2013-C-1', '2013-C-2', '2013-C-3',
			)), json_encode($result));
	}

	private function _getResultItemMock($return)
	{
		$result_item = $this->getMockBuilder('\Modules\Analyzes\Components\DataBuilder\Objects\ResultItem')
			->getMock();

		$result_item->expects($this->any())
			->method('getYearValue')
			->will($this->returnValue($return[0]));

		$result_item->expects($this->any())
			->method('getCategoryName')
			->will($this->returnValue($return[1]));

		$result_item->expects($this->any())
			->method('getMonthValue')
			->will($this->returnValue($return[2]));

		return $result_item;
	}
} 