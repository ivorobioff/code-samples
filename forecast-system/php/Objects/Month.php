<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects;

use Modules\Analyzes\Components\DataBuilder\Objects\Cells\AbstractCell;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class Month 
{
	private $_cell;
	private $_value;
	private $_year;

	private $_is_arranged = false;

	public function __construct($value, AbstractCell $cell)
	{
		$this->_value = $value;

		$cell->setMonth($this);
		$this->_cell = $cell;
	}

	public function getCell()
	{
		return $this->_cell;
	}

	public function getValue()
	{
		return $this->_value;
	}

	public function setYear(Year $year)
	{
		$this->_year = $year;
	}

	/**
	 * @return Year
	 */
	public function getYear()
	{
		return $this->_year;
	}

	public function setItsArranged()
	{
		$this->_is_arranged = true;
	}

	public function isArranged()
	{
		return $this->_is_arranged;
	}
}