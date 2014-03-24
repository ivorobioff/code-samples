<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class Category
{
	private $_cache_prepared_data;
	private $_data;

	public function __construct(array $data)
	{
		$this->_data = $data;
	}

	public function getValueByDate(Date $date)
	{
		$data = $this->_getPreparedData();
		return setif($data, $date->format('Y-m'), null);
	}

	private function _getPreparedData()
	{
		if (is_null($this->_cache_prepared_data))
		{
			foreach ($this->_data as $row)
			{
				$date = new Date($row->date);
				$key = $date->format('Y-m');

				if (!isset($this->_cache_prepared_data[$key]))
				{
					$this->_cache_prepared_data[$key] = 0;
				}

				$this->_cache_prepared_data[$key] += $row->amount;
			}
		}

		return $this->_cache_prepared_data;
	}

	public function getName()
	{
		reset($this->_data);
		$model = current($this->_data);
		return $model->name;
	}
}