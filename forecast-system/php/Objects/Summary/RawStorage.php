<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Summary;


/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class RawStorage extends \IteratorIterator
{
	public function __construct()
	{
		parent::__construct(new \ArrayIterator());
	}

	public function addYearItem(YearItem $year_item)
	{
		$total_years = $this->getInnerIterator();

		$year_value = $year_item->getYear()->getValue();

		if (!isset($total_years[$year_value]))
		{
			$total_years[$year_value] = new YearTotals($year_value);
		}

		$total_years[$year_value]->addYearItem($year_item);
	}

	public function rewind()
	{
		$this->getInnerIterator()->ksort();
		parent::rewind();
	}

	/**
	 * @param $year
	 * @return null|YearTotals
	 */
	public function findByYear($year)
	{
		$total_years = $this->getInnerIterator();

		if (!isset($total_years[$year])) return null;
		return $total_years[$year];
	}
}