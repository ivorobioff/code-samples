<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects;
use Modules\Analyzes\Components\DataBuilder\Objects\Cells\AbstractCell;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class ResultItem 
{
	/**
	 * @var Year
	 */
	private $_year;
	/**
	 * @var Category
	 */
	private $_cat;
	/**
	 * @var AbstractCell
	 */
	private $_cell;
	/**
	 * @var Month
	 */
	private $_month;

	public function setYear(Year $year)
	{
		$this->_year = $year;
	}

	public function setMonth(Month $month)
	{
		$this->_month = $month;
	}

	public function setCategory(Category $cat)
	{
		$this->_cat = $cat;
	}

	public function setCell(AbstractCell $cell)
	{
		$this->_cell = $cell;
	}

	public function getCategoryName()
	{
		return $this->_cat->getName();
	}

	public function getMonthValue()
	{
		return $this->_month->getValue();
	}

	public function getYearValue()
	{
		return $this->_year->getValue();
	}

	public function getCellValue()
	{
		return $this->_cell->getValue();
	}
} 