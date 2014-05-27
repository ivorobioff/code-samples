<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class Heap extends \SplHeap
{
	private $_criteria;

	public function __construct(\Closure $criteria)
	{
		$this->_criteria = $criteria;
	}

	/**
	 * @param ResultItem $item1
	 * @param ResultItem $item2
	 * @return int
	 */
	protected function compare($item1, $item2)
	{
		$id1 = call_user_func($this->_criteria, $item1);
		$id2 = call_user_func($this->_criteria, $item2);

		if (strnatcmp($id1, $id2) < 0) return 1;
		if (strnatcmp($id1, $id2) > 0) return -1;

		return 0;
	}
}