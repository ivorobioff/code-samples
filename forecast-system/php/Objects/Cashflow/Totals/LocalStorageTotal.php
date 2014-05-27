<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Totals;

use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Month;
use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Cells\AbstractCell;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
abstract class LocalStorageTotal extends AbstractTotal
{
	public function getTotal()
	{
		$total = 0;

		/**
		 * @var Month $month
		 */
		foreach ($this->_months as $month)
		{
			$total += $this->_findCell($month)->getValue();
		}

		return $total;
	}

	public function getText()
	{
		return $this->_findCell($this->_months->bottom())->getLabel()->getText();
	}

	/**
	 * @param Month $month
	 * @return AbstractCell
	 */
	abstract protected function _findCell(Month $month);
} 