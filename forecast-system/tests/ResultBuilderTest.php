<?php
namespace UnitTests\Analyzes\Components\DataBuilder;
use Modules\Analyzes\Components\DataBuilder\Objects\Category;
use Modules\Analyzes\Components\DataBuilder\Objects\Cells\ActualCell;
use Modules\Analyzes\Components\DataBuilder\Objects\Date;
use Modules\Analyzes\Components\DataBuilder\Objects\Month;
use Modules\Analyzes\Components\DataBuilder\Objects\Sheet;
use Modules\Analyzes\Components\DataBuilder\Objects\ResultBuilder;
use Modules\Analyzes\Components\DataBuilder\Objects\Year;
use Modules\Analyzes\Components\DataBuilder\Objects\Heap;
use Modules\Analyzes\Components\DataBuilder\Objects\ResultItem;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class ResultBuilderTest extends \PHPUnit_Framework_TestCase
{
	public function testUnwantedItemsSkipped()
	{
		$builder = new ResultBuilder();

		$sheet = new Sheet(new Category(array((object) array('name' => 'A'))));


		$year = new Year(2013);

		for ($i = 1; $i <= 12; $i++)
		{
			$month = new Month($i, new ActualCell(100));
			$month->setItsArranged();
			$year->addMonth($month);
		}

		$sheet->addYear($year);

		$year = new Year(2014);

		for ($i = 1; $i <= 12; $i++)
		{
			$month = new Month($i, new ActualCell(100));

			if ($i < 7) $month->setItsArranged();

			$year->addMonth($month);
		}

		$sheet->addYear($year);

		$sheets = new \SplDoublyLinkedList();
		$sheets->push($sheet);

		$builder->populate($sheets);

		$ref =new \ReflectionObject($builder);
		$ref = $ref->getProperty('_heap');
		$ref->setAccessible(true);

		/**
		 * @var Heap $heap
		 */
		$heap = $ref->getValue($builder);

		$items = iterator_to_array($heap);

		$this->assertEquals(6, count($items));
	}

	public function testCreateResultItem()
	{
		$builder = new ResultBuilder();
		$sheet = new Sheet(new Category(array((object) array('name' => 'A'))));

		$year = new Year(2013);
		$year->addMonth(new Month(1, new ActualCell(100)));
		$sheet->addYear($year);

		$sheets = new \SplDoublyLinkedList();
		$sheets->push($sheet);

		$builder->populate($sheets);

		$ref =new \ReflectionObject($builder);
		$ref = $ref->getProperty('_heap');
		$ref->setAccessible(true);

		/**
		 * @var ResultItem $item
		 */
		$item = $ref->getValue($builder)->top();

		$this->assertEquals('A', $item->getCategoryName());
		$this->assertEquals(2013, $item->getYearValue());
		$this->assertEquals(1, $item->getMonthValue());
		$this->assertEquals(100, $item->getCellValue());
	}

	public function testToArray()
	{
		$builder = new ResultBuilder();

		$sheets = new \SplDoublyLinkedList();

		for ($i = 2013; $i <= 2015; $i++)
		{
			$sheets->push($this->_creatSheet($i, 'B'));
			$sheets->push($this->_creatSheet($i, 'A'));
			$sheets->push($this->_creatSheet($i, 'C'));
		}

		$builder->populate($sheets);

		$this->assertEquals(json_encode(array(
			2013 => array(
				'A' => array(
					1 => 100,
					2 => 200,
					3 => 300,
				),
				'B' => array(
					1 => 100,
					2 => 200,
					3 => 300,
				),
				'C' => array(
					1 => 100,
					2 => 200,
					3 => 300,
				),
			),
			2014 => array(
				'A' => array(
					1 => 100,
					2 => 200,
					3 => 300,
				),
				'B' => array(
					1 => 100,
					2 => 200,
					3 => 300,
				),
				'C' => array(
					1 => 100,
					2 => 200,
					3 => 300,
				),
			),
			2015 => array(
				'A' => array(
					1 => 100,
					2 => 200,
					3 => 300,
				),
				'B' => array(
					1 => 100,
					2 => 200,
					3 => 300,
				),
				'C' => array(
					1 => 100,
					2 => 200,
					3 => 300,
				),
			)
		)), json_encode($builder->toArray()));
	}

	private function _creatSheet($year, $cat)
	{
		$sheet = new Sheet(new Category(array((object) array('name' => $cat))));

		$year = new Year($year);

		$year->addMonth(new Month(1, new ActualCell(100)));
		$year->addMonth(new Month(2, new ActualCell(200)));
		$year->addMonth(new Month(3, new ActualCell(300)));

		$sheet->addYear($year);

		return $sheet;
	}
} 