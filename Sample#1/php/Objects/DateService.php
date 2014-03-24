<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class DateService
{
	private $_date_from;
	private $_date_to;
	private $_now;

	public function __construct(Date $date_from, Date $date_to, Date $now)
	{
		$this->_date_from = $date_from;
		$this->_date_to = $date_to;
		$this->_now = $now;
	}

	/**
	 * @return Date
	 */
	public function from()
	{
		return $this->_date_from;
	}

	/**
	 * @return Date
	 */
	public function to()
	{
		return $this->_date_to;
	}

	/**
	 * @return Date
	 */
	public function now()
	{
		return $this->_now;
	}

	/**
	 * @return Date
	 */
	public function fakeFrom()
	{
		$now = new Date($this->now()->format('Y-m-d H:i:s'));
		$now->setDate($now->getYear(), 1, 1);
		$now->sub(new \DateInterval('P1Y'));

		if ($this->from()->getTimestamp() < $now->getTimestamp()) return $this->from();

		return $now;
	}
} 