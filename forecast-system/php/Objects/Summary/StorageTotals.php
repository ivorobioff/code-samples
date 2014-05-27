<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Summary;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class StorageTotals extends \FilterIterator
{
	public function accept()
	{
		return !$this->getInnerIterator()->current()->isArranged();
	}

	/**
	 * @param int $year
	 */
	public function findByYear($year)
	{
		return $this->getInnerIterator()->findByYear($year);
	}
}