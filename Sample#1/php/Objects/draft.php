<?php
class Core
{
	private $_sheets_maker;

	public function __construct(SheetsMaker $sheets_maker)
	{
		$this->_sheets_maker = $sheets_maker;
	}

	public function build()
	{
		$storage = new \SplDoublyLinkedList();

		foreach ($this->_sheets_maker as $sheet)
		{
			$storage->push($sheet);
		}

		return $storage;
	}
}

class ResultBuilder
{
	private $_heap;

	public function __construct()
	{
		$this->_heap = new Heap();
	}

	public function toArray()
	{

	}

	public function addSheet(Sheet $sheet)
	{
		$this->_heap;
	}
}

class ResultItem
{

}

class Heap extends SplHeap
{
	protected function compare($value1, $value2)
	{
		// TODO: Implement compare() method.
	}
}

class SheetsMaker extends IteratorIterator
{
	private $months_maker;

	public function __construct(MonthsMaker $months_maker, array $years)
	{
		parent::current(new ArrayIterator($years));
		$this->months_maker = $months_maker;
	}

	public function current()
	{
		$year_range = parent::current();

		$sheet = new Sheet($year_range->getValue());

		foreach ($this->months_maker as $month)
		{
			$sheet->addMonth($month);
		}

		return $sheet;
	}
}

class MonthsMaker extends IteratorIterator
{
	private $_labels_provider;
	private $_summary;

	private $_prior_month;

	public function __construct(SummaryProvider $summary, $months)
	{
		parent::current(new ArrayIterator($months));
		$this->_summary = $summary;
	}

	public function current()
	{
		$month_range = parent::current();
		$month = new Month($month_range->getValue());

		$label = $this->_labels_provider->getCashLabel();
		$month->setCashCell(new CashCell($label));

		$label = $this->_labels_provider->getExpensesLabel();
		$total = $this->_summary
				->getExpensesSummary()
				->getMonth($month_range->getValue())
				->getTotal();

		$month->setExpensesCell(new LocalStorageCell($total, $label));

		$label = $this->_labels_provider->getSalesLabel();

		$total = $this->_summary
			->getSalesSummary()
			->getMonth($month_range->getValue())
			->getTotal();

		$month->setSalesCell(new LocalStorageCell($total, $label));

		$label = $this->_labels_provider->getTotalLabel();
		$month->setTotalCell(new TotalCell($label));

		if (!is_bool($this->_prior_month)) $month->setPriorMonth($month);

		$this->_prior_month = $month;

		return $month;
	}

	public function setLabelsProvider(LabelsProvider $labels_provider)
	{
		$this->_labels_provider = $labels_provider;
	}
}


class SummaryProvider
{
	public function getExpensesSummary()
	{

	}

	public function getSalesSummary()
	{

	}
}


class DateRange {}
class Sheet {}



class Month
{
	/**
	 * @var Month
	 */
	private $_prior_month;

	private $_cash_cell;
	private $_expenses_cell;
	private $_sales_cell;
	private $_total_cell;

	public function setPriorMonth(Month $prior_month)
	{
		$this->_prior_month = $prior_month;
	}

	/**
	 * @param CashCell $cash_cell
	 */
	public function setCashCell(CashCell $cash_cell)
	{
		$this->_cash_cell = $cash_cell;
	}

	/**
	 * @return CashCell
	 */
	public function getCashCell()
	{
		return $this->_cash_cell;
	}

	/**
	 * @param LocalStorageCell $expenses_cell
	 */
	public function setExpensesCell(LocalStorageCell $expenses_cell)
	{
		$this->_expenses_cell = $expenses_cell;
	}

	/**
	 * @return LocalStorageCell
	 */
	public function getExpensesCell()
	{
		return $this->_expenses_cell;
	}

	/**
	 * @param LocalStorageCell $sales_cell
	 */
	public function setSalesCell(LocalStorageCell $sales_cell)
	{
		$this->_sales_cell = $sales_cell;
	}

	/**
	 * @return LocalStorageCell
	 */
	public function getSalesCell()
	{
		return $this->_sales_cell;
	}

	/**
	 * @param TotalCell $total_cell
	 */
	public function setTotalCell(TotalCell $total_cell)
	{
		$this->_total_cell = $total_cell;
	}

	/**
	 * @return TotalCell
	 */
	public function getTotalCell()
	{
		return $this->_total_cell;
	}

	public function getLastTotal()
	{
		return $this->_prior_month->getTotalCell();
	}
}


class LabelsProvider
{
	public function getCashLabel()
	{
		return null;
	}

	public function getExpensesLabel()
	{
		return null;
	}

	public function getSalesLabel()
	{
		return null;
	}
}


class Label
{
	public function getText()
	{

	}

	public function getOrderNumber()
	{

	}
}

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

class CashCell extends AbstractCell
{
	private $_init_amount;

	public function __construct(Label $label, $init_amount = 0)
	{
		$this->_init_amount = $init_amount;
	}

	public function getValue()
	{
		return $this->_month->getLastTotal() + $this->_init_amount;
	}
}

class LocalStorageCell extends AbstractCell
{
	private $_value;

	public function __construct($value, Label $label)
	{
		parent::__construct($label);
		$this->_value = $value;
	}

	public function getValue()
	{
		return $this->_value;
	}
}


class TotalCell extends AbstractCell
{
	public function getValue()
	{
		$cash = $this->_month->getCashCell();
		$sales = $this->_month->getSalesCell();
		$expenses = $this->_month->getExpensesCell();

		return (($cash + $sales) - $expenses);
	}
}