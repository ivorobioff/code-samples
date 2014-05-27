<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Cashflow;
use Modules\Analyzes\Components\DataBuilder\Objects\Cashflow\Cells\AbstractCell;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class ResultItem 
{
	/**
	 * @var Label
	 */
	private $_label;

	/**
	 * @var Sheet
	 */
	private $_sheet;

	/**
	 * @var Month
	 */
	private $_month;

	/**
	 * @var AbstractCell
	 */
	private $_cell;

	public function setLabel(Label $label)
	{
		$this->_label = $label;
	}

	public function setSheet(Sheet $sheet)
	{
		$this->_sheet = $sheet;
	}

	public function setMonth(Month $month)
	{
		$this->_month = $month;
	}

	public function setCell(AbstractCell $cell)
	{
		$this->_cell = $cell;
	}

	public function getLabel()
	{
		return $this->_label;
	}

	public function getYearValue()
	{
		return $this->_sheet->getYearValue();
	}

	public function getMonthValue()
	{
		return $this->_month->getMonthValue();
	}

	public function getCellValue()
	{
		return $this->_cell->getValue();
	}
} 