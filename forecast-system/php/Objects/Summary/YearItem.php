<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Summary;
use Modules\Analyzes\Components\DataBuilder\Objects\Category;
use Modules\Analyzes\Components\DataBuilder\Objects\Year;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class YearItem
{
	private $_category;
	private $_year;

	public function __construct(Year $year, Category $category)
	{
		$this->_category = $category;
		$this->_year = $year;
	}

	public function getCategory()
	{
		return $this->_category;
	}

	public function getYear()
	{
		return $this->_year;
	}
} 