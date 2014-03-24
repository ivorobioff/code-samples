<?php
namespace Modules\Analyzes\Components\DataBuilder\Objects;

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class CategoriesIterator extends \IteratorIterator
{
	public function __construct(array $models)
	{
		parent::__construct(new \ArrayIterator($this->_groupModelsByCategories($models)));
	}

	private function _groupModelsByCategories(array $models)
	{
		$cats = array();

		foreach ($models as $item)
		{
			$cats[md5($item->name)][] = $item;
		}

		return $cats;
	}

	public function current()
	{
		$cat = parent::current();
		if ($cat instanceof Category) return $cat;

		$cat = new Category($cat);

		$inner_iterator = $this->getInnerIterator();
		$inner_iterator[$this->key()] = $cat;

		return $cat;
	}
} 