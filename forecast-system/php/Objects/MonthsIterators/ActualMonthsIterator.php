<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\MonthsIterators;

use Modules\Analyzes\Components\DataBuilder\Objects\Cells\ActualCell;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class ActualMonthsIterator extends AbstractMonthsIterator
{
	public function accept()
	{
		return $this->current()->getCell() instanceof ActualCell;
	}
}