<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\MonthsIterators;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
abstract class AbstractMonthsIterator extends \FilterIterator implements \Countable
{
	public function count()
	{
		return count(iterator_to_array($this));
	}

	public function toArray()
	{
		return iterator_to_array($this);
	}
} 