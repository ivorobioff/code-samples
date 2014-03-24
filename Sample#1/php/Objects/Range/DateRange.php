<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects\Range;

use Modules\Analyzes\Components\DataBuilder\Objects\Date;
use Modules\Analyzes\Components\DataBuilder\Objects\DateService;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class DateRange
{
	private $_fake_from;
	private $_date_service;

	private $_years;
	private $_future_flag = true;

	public function __construct(DateService $date_service, Date $fake_from = null)
	{
		$this->_fake_from = is_null($fake_from) ? $date_service->from() : $fake_from;
		$this->_date_service = $date_service;
	}

	public function getYears()
	{
		if (!is_null($this->_years)) return $this->_years;

		$from = new Date($this->_fake_from->format('Y-m-01'));
		$to = new Date($this->_date_service->to()->format('Y-m-02'));

		$range = new \DatePeriod($from, new \DateInterval('P1M'), $to);

		foreach ($range as $date)
		{
			$date = new Date($date->format('Y-m-d'));

			$month_range = new MonthRange($date->getMonth());

			if ($this->_isFuture($date))
			{
				if ($this->_future_flag)
				{
					$month_range->setItsFirstFuture();
				}

				$month_range->setItsFuture();
				$this->_future_flag = false;
			}
			if ($this->_isFake($date)) $month_range->setItsFake();


			$this->_getYear($date->getYear())->addMonth($month_range);
		}

		return $this->_years;
	}

	/**
	 * @param $num
	 * @return YearRange
	 */
	protected function _getYear($num)
	{
		if (!isset($this->_years[$num]))
		{
			$this->_years[$num] = new YearRange($num);
		}

		return $this->_years[$num];
	}


	private function _isFuture(Date $date)
	{
		$year_now = $this->_date_service->now()->getYear();
		$month_now = $this->_date_service->now()->getMonth();

		$year = $date->getYear();
		$month = $date->getMonth();

		if ($year > $year_now) return true;
		if ($year == $year_now && $month >= $month_now) return true;

		return false;
	}

	private function _isFake(Date $date)
	{
		$year_from = $this->_date_service->from()->getYear();
		$month_from = $this->_date_service->from()->getMonth();

		$year = $date->getYear();
		$month = $date->getMonth();

		if ($year < $year_from) return true;
		if ($year == $year_from && $month < $month_from) return true;

		return false;
	}
} 