<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cells;
use Modules\Analyzes\Components\DataBuilder\Objects\Month;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
abstract class AbstractCell
{
	/**
	 * @var Month
	 */
	protected $_month;

	abstract public function getValue();

	public function setMonth(Month $month)
	{
		$this->_month = $month;
	}
} 