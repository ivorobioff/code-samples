<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class Core
{
	/**
	 * @var SheetMaker
	 */
	private $_maker;

	public function __construct(SheetMaker $maker)
	{
		$this->_maker = $maker;
	}

	public function getSheetsStorage()
	{
		$storage = new \SplDoublyLinkedList();

		foreach ($this->_maker as $sheet)
		{
			$storage->push($sheet);
		}

		return $storage;
	}
} 