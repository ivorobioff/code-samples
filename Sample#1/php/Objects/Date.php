<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class Date extends \DateTime
{
	public function getYear()
	{
		return (int) $this->format('Y');
	}

	public function getMonth()
	{
		return (int) $this->format('n');
	}

	public function getDate()
	{
		return (int) $this->format('j');
	}

	public function toString()
	{
		return $this->format('Y-m-d');
	}
} 