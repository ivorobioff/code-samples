<?php

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class Posts extends AbstractModel
{
	public function toArray()
	{
		$data = parent::toArray();
		$data['comments'] = new EmptyCommentsIterator();
		return $data;
	}

	public function validate(array $data)
	{
		(new Validator($data))->validate();
	}

	public function add(array $data)
	{
		$res = Db::instance()
			->query('
				INSERT INTO `posts` (`name`, `email`, `message`, `insert_date`)
				VALUES(
				"'.Db::instance()->real_escape_string($data['name']).'",
				"'.Db::instance()->real_escape_string($data['email']).'",
				"'.Db::instance()->real_escape_string($data['message']).'",
				"'.$data['insert_date'].'")
			');

		if (!$res) throw new Exception(Db::instance()->error);

		return Db::instance()->insert_id;
	}

	public function getAll()
	{
		$res = Db::instance()->query('SELECT * FROM `posts` ORDER BY `id` ASC');

		/**
		 * Skipping in case of error.
		 * Users should not know anything about the error.
		 * Normally, the error would be logged.
		 */
		if (!$res) return new EmptyIterator();
		return new PostsInterator($res);
	}
} 