<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Cells;
use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Label;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class CashCell extends AbstractCell
{
	private $_init_value;

	public function __construct(Label $label, $init_value = null)
	{
		parent::__construct($label);
		$this->_init_value = $init_value;
	}

	public function getValue()
	{
		if (!is_null( $this->_init_value)) return  $this->_init_value;
		return $this->_month->getPrevTotalValue() + $this->_init_value;
	}
}