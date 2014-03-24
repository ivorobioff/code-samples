<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Totals;

use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Month;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class ExpensesTotal extends LocalStorageTotal
{
	protected function _findCell(Month $month)
	{
		return $month->getExpensesCell();
	}
}