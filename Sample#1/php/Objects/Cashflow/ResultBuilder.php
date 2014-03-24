<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cashflow;

use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Cells\AbstractCell;
use Modules\Analyzes\Components\DataBuilder\Objects\Heap;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class ResultBuilder 
{
	private $_heap;

	public function __construct()
	{
		$this->_heap = new Heap(function(ResultItem $item){
			return $item->getYearValue().'-'.$item->getLabel()->getId().'-'.$item->getMonthValue();
		});
	}

	public function populate(\SplDoublyLinkedList $sheets)
	{
		/**
		 * @var Sheet $sheet
		 */
		foreach ($sheets as $sheet)
		{
			/**
			 * @var Month $month
			 */
			foreach ($sheet->getMonths() as $month)
			{
				/**
				 * @var AbstractCell $cell
				 */
				foreach ($month->getCells() as $cell)
				{
					$result_item = new ResultItem();

					$result_item->setSheet($sheet);
					$result_item->setLabel($cell->getLabel());
					$result_item->setMonth($month);
					$result_item->setCell($cell);

					$this->_heap->insert($result_item);
				}

			}
		}
	}

	public function toArray()
	{
		$res = array();

		/**
		 * @var ResultItem $item
		 */
		foreach ($this->_heap as $item)
		{
			$res[$item->getYearValue()][$item->getLabel()->getText()][$item->getMonthValue()] = $item->getCellValue();
		}

		return $res;
	}
} 