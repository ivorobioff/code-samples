<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class OffsetDateFactory 
{
	private $_offset_days;

	public function __construct($offset_days)
	{
		$this->_offset_days = $offset_days;
	}

	public function shiftBack(Date $date)
	{
		return $this->_shift($date, true);
	}

	public function shiftForward(Date $date)
	{
		return $this->_shift($date);
	}

	private function _shift(Date $date, $back = false)
	{
		$date = new Date($date->format('Y-m-d H:i:s'));

		if ($this->_offset_days == 0) return $date;

		$m = $this->_calcMonthsNumByOffset();

		if (!$back)
		{
			$date->add(new \DateInterval('P'.$m.'M'));
		}
		else
		{
			$date->sub(new \DateInterval('P'.$m.'M'));
		}

		return $date;
	}

	private function _calcMonthsNumByOffset()
	{
		return ceil($this->_offset_days / 30);
	}
} 