<?php
namespace Modules\Analyzes\Components\DataBuilder\Factory;

use Modules\Analyzes\Components\DataBuilder\Objects\CategoriesIterator;
use Modules\Analyzes\Components\DataBuilder\Objects\Category;
use Modules\Analyzes\Components\DataBuilder\Objects\Core;
use Modules\Analyzes\Components\DataBuilder\Objects\Date;
use Modules\Analyzes\Components\DataBuilder\Objects\DateService;
use Modules\Analyzes\Components\DataBuilder\Objects\OffsetDateFactory;
use Modules\Analyzes\Components\DataBuilder\Objects\Range\DateRange;
use Modules\Analyzes\Components\DataBuilder\Objects\SheetMaker;
use Modules\Analyzes\Components\DataBuilder\Objects\YearMaker;

/**
 * @author Igor Vorobiov<vib@avantajprim.com>
 */
class LocalStorageBuilder
{
	private $_date_from;
	private $_date_to;

	/**
	 * @var \CActiveRecord
	 */
	private $_local_storage;
	private $_revise_by = 0;
	private $_revise_exceptions = array();

	private $_offset_days = 0;

	public function setDateRange(Date $date_from, Date $date_to)
	{
		$this->_date_from = $date_from;
		$this->_date_to = $date_to;

		return $this;
	}

	/**
	 * @param \CActiveRecord $local_storage
	 * @return $this
	 */
	public function setLocalStorage(\CActiveRecord $local_storage)
	{
		$this->_local_storage = $local_storage;

		return $this;
	}

	public function setReviseBy($value, array $revise_exceptions = array())
	{
		$this->_revise_by = $value;
		$this->_revise_exceptions = $revise_exceptions;

		return $this;
	}

	public function setOffsetDays($days)
	{
		$this->_offset_days = $days;

		return $this;
	}

	public function build()
	{
		$date_factory = new OffsetDateFactory($this->_offset_days);

		$date_service = new DateService($this->_date_from, $this->_date_to, $date_factory->shiftForward(new Date()));

		$models = $this->_fetchModels(
			$date_factory->shiftBack($date_service->fakeFrom()),
			$date_service->to());

		$range = new DateRange($date_service, new Date($models[0]->date));

		$sheets = new SheetMaker(new CategoriesIterator($models));

		$revise_by = $this->_revise_by;
		$revise_exceptions = $this->_revise_exceptions;

		$sheets->setYearMakerFactory(
			function(Category $cat) use ($range, $revise_by, $revise_exceptions, $date_factory){
				$maker = new YearMaker($range->getYears(), $cat);
				$maker->setReviseBy(in_array($cat->getName(), $revise_exceptions) ? 0 : $revise_by);
				$maker->setOffsetDateFactory($date_factory);

				return $maker;
			});

		return new Core($sheets);
	}

	private function _fetchModels(Date $from, Date $to)
	{
		return $this->_local_storage->findAllByAttributes(
			array('user_id'=> \Yii::app()->user->id),
			array('order' => '`date` ASC',
				'condition' => '`date` >= :date_from AND `date` <= :date_to',
				'params' => array(
					':date_from' => $from->toString(),
					':date_to' => $to->toString()
				)));
	}
}