<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Cells;

use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Label;
use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Month;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
abstract class AbstractCell
{
	private $_label;

	/**
	 * @var Month
	 */
	protected $_month;

	public function __construct(Label $label)
	{
		$this->_label = $label;
	}

	/**
	 * @return Label
	 */
	public function getLabel()
	{
		return $this->_label;
	}

	public function setMonth(Month $month)
	{
		$this->_month = $month;
	}

	abstract public function getValue();
} 