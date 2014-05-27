<?php

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class PostsInterator extends ResultIterator
{
	public function current()
	{
		$post = parent::current();
		$comments = new Comments();
		$post['comments'] = $comments->getAllByPostId($post['id']);

		return $post;
	}
}