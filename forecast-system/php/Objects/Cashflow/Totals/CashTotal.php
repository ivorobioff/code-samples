<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Totals;
use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Month;
/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class CashTotal extends AbstractTotal
{
	/**
	 * @var Month
	 */
	private $_first_month;

	public function __construct(\SplDoublyLinkedList $months)
	{
		parent::__construct($months);
		$this->_first_month = $this->_months->bottom();
	}

	public function getTotal()
	{
		return $this->_first_month->getCashCell()->getValue();
	}

	public function getText()
	{
		return $this->_first_month->getCashCell()->getLabel()->getText();
	}
}