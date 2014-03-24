<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cashflow;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class Core
{
	private $_sheets_maker;

	public function __construct(SheetsMaker $sheets_maker)
	{
		$this->_sheets_maker = $sheets_maker;
	}

	public function getSheetsStorage()
	{
		$storage = new \SplDoublyLinkedList();

		foreach ($this->_sheets_maker as $sheet)
		{
			$storage->push($sheet);
		}

		return $storage;
	}
} 