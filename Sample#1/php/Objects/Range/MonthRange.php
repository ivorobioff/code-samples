<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Range;

use Modules\Analyzes\Components\DataBuilder\Objects\Date;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class MonthRange 
{
	/**
	 * @var YearRange
	 */
	protected $_year;
	protected $_value;

	protected $_now;

	private $_is_fake = false;
	private $_is_future = false;
	private $_is_first_future = false;

	public function __construct($value)
	{
		$this->_value = $value;
	}

	public function isFuture()
	{
		return $this->_is_future;
	}

	public function isFirstFuture()
	{
		return $this->_is_first_future;
	}

	public function getValue()
	{
		return $this->_value;
	}

	public function setYear(YearRange $year)
	{
		$this->_year = $year;
	}

	public function setItsFake()
	{
		return $this->_is_fake = true;
	}

	public function isFake()
	{
		return $this->_is_fake;
	}

	public function setItsFuture()
	{
		$this->_is_future = true;
	}

	public function setItsFirstFuture()
	{
		$this->_is_first_future = true;
	}
}