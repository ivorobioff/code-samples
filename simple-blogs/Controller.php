<?php
/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class Controller
{
	public function index()
	{
		$post = new Posts();

		View::assignGlobal('captcha', Captcha::update());

		View::create('index.php')
			->assign('posts_iterator', $post->getAll())
			->render();
	}

	public function addPost()
	{
		$post = Posts::create($_POST);

		try
		{
			$post->save();
		}
		catch (ValidationFail $ex)
		{
			echo json_encode(array('status' => 'error', 'message' => $ex->getMessage()));
			return ;
		}
		catch (Exception $ex)
		{
			echo json_encode(array('status' => 'error', 'message' => 'Something went wrong'));
			return ;
		}

		View::assignGlobal('captcha', Captcha::get());

		echo json_encode(array(
			'status' => 'success',
			'view' => View::create('post.php')->assign('data', $post->toArray())->render(false)
		));
	}

	public function addComment()
	{
		$comment = Comments::create($_POST);

		try
		{
			$comment->save();
		}
		catch (ValidationFail $ex)
		{
			echo json_encode(array('status' => 'error', 'message' => $ex->getMessage()));
			return ;
		}
		catch (Exception $ex)
		{
			echo json_encode(array('status' => 'error', 'message' => 'Something went wrong'));
			return ;
		}

		echo json_encode(array(
			'status' => 'success',
			'view' => View::create('comment.php')->assign('data', $comment->toArray())->render(false)
		));
	}
} 