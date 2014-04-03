<?php

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class Comments extends AbstractModel
{
	public function validate(array $data)
	{
		(new Validator($data))->validateComment();
	}

	public function add(array $data)
	{
		$res = Db::instance()
			->query('
				INSERT INTO `comments` (`post_id`, `name`, `email`, `message`, `insert_date`)
				VALUES(
				"'.(int) $data['post_id'].'",
				"'.Db::instance()->real_escape_string($data['name']).'",
				"'.Db::instance()->real_escape_string($data['email']).'",
				"'.Db::instance()->real_escape_string($data['message']).'",
				"'.$data['insert_date'].'")
			');

		if (!$res) throw new Exception(Db::instance()->error);

		return Db::instance()->insert_id;
	}

	public function getAllByPostId($post_id)
	{
		$res = Db::instance()->query('SELECT * FROM `comments` WHERE `post_id`='.$post_id.' ORDER BY `id` ASC');

		if (!$res) return new EmptyCommentsIterator();
		return new ResultIterator($res);
	}
} 