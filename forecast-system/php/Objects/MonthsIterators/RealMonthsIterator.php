<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\MonthsIterators;

use Modules\Analyzes\Components\DataBuilder\Objects\Cells\NullCell;


/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class RealMonthsIterator extends AbstractMonthsIterator
{
	public function accept()
	{
		return !$this->current()->getCell() instanceof NullCell;
	}
} 