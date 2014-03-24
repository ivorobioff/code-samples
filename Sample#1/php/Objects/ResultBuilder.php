<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class ResultBuilder 
{
	/**
	 * @var Heap
	 */
	private $_heap;

	public function __construct()
	{
		$this->_heap = new Heap(function(ResultItem $item){
			return $item->getYearValue().'-'.$item->getCategoryName().'-'.$item->getMonthValue();
		});
	}

	public function toArray()
	{
		$res = array();

		/**
		 * @var ResultItem $item
		 */
		foreach ($this->_heap as $item)
		{
			$res[$item->getYearValue()][$item->getCategoryName()][$item->getMonthValue()] = $item->getCellValue();
		}

		return $res;
	}

	public function populate(\SplDoublyLinkedList $sheets)
	{
		foreach ($sheets as $sheet)
		{
			$this->_addSheet($sheet);
		}
	}

	private function _addSheet(Sheet $sheet)
	{
		/**
		 * @var Year $year
		 */
		foreach ($sheet->getYears() as $year)
		{
			if ($year->isArranaged()) continue ;

			/**
			 * @var Month $month
			 */
			foreach ($year->getMonths() as $month)
			{
				if ($month->isArranged()) continue;

				$item = new ResultItem();
				$item->setYear($year);
				$item->setCategory($sheet->getCategory());
				$item->setMonth($month);
				$item->setCell($month->getCell());

				$this->_heap->insert($item);
			}
		}
	}
} 