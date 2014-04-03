<?php

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class EmptyCommentsIterator extends EmptyIterator implements Countable
{
	public function count()
	{
		return 0;
	}
} 