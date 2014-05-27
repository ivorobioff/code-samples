<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Summary;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class CategoryTotals
{
	private $_total = 0;

	private $_name;

	public function __construct($name)
	{
		$this->_name = $name;
	}

	public function sumTotal($num)
	{
		if (is_null($num)) return ;

		$this->_total += $num;
	}

	public function getTotal()
	{
		return $this->_total;
	}

	public function getName()
	{
		return $this->_name;
	}
} 