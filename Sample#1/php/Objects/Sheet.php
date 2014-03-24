<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class Sheet 
{
	private $_cat;
	private $_years;

	public function __construct(Category $cat)
	{
		$this->_cat = $cat;
	}

	public function addYear(Year $year)
	{
		$this->_years[] = $year;
	}

	public function getYears()
	{
		return $this->_years;
	}

	public function getCategory()
	{
		return $this->_cat;
	}
} 