<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class SheetMaker extends \IteratorIterator
{
	private $_factory;

	public function current()
	{
		/**
		 * @var Category $cat
		 */
		$cat = parent::current();

		$sheet = new Sheet($cat);

		/**
		 * @var YearMaker $year_maker
		 */
		$years_maker = call_user_func($this->_factory, $cat);

		/**
		 * @var Year $year
		 */
		foreach ($years_maker as $year)
		{
			$sheet->addYear($year);
		}

		return $sheet;
	}

	public function setYearMakerFactory(\Closure $factory)
	{
		$this->_factory = $factory;
	}
} 