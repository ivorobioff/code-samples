<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Totals;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
abstract class AbstractTotal
{
	/**
	 * @var \SplDoublyLinkedList
	 */
	protected $_months;

	public function __construct(\SplDoublyLinkedList $months)
	{
		$this->_months = $months;
	}

	abstract public function getText();
	abstract public function getTotal();
} 