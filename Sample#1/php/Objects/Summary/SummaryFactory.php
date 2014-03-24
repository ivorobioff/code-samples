<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Summary;

use Extensions\Utils\SubIteratorIterator;
use Modules\Analyzes\Components\DataBuilder\Objects\Sheet;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class SummaryFactory
{
	private $_exploder;

	public function __construct(\SplDoublyLinkedList $sheets)
	{
		$this->_exploder = new SubIteratorIterator($sheets,
			function(Sheet $sheet){

				$buffer = new \SplDoublyLinkedList();

				foreach ($sheet->getYears() as $year)
				{
					$buffer->push(new YearItem($year, $sheet->getCategory()));
				}

				return $buffer;
			});
	}

	public function build()
	{
		$storage = new RawStorage();

		foreach ($this->_exploder as $item)
		{
			$storage->addYearItem($item);
		}

		return new StorageTotals($storage);
	}
} 