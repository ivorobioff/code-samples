<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cashflow;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class LabelsProvider 
{
	private $_expenses_label;
	private $_sales_label;
	private $_cash_label;
	private $_total_label;

	public function __construct()
	{
		$this->_cash_label = new Label(1, '$ at Bank');
		$this->_expenses_label = new Label(2, 'Expenses');
		$this->_sales_label = new Label(3, 'Cash In');
		$this->_total_label = new Label(4, 'Total');
	}

	public function getExpensesLabel()
	{
		return $this->_expenses_label;
	}

	public function getSalesLabel()
	{
		return $this->_sales_label;
	}

	public function getCashLabel()
	{
		return $this->_cash_label;
	}

	public function getTotalLabel()
	{
		return $this->_total_label;
	}
} 