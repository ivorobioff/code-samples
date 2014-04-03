<div class="post-menu">
	<span class="w-comment" onclick="show_comments(this)">Write comment (<span data-comments-total="<?=$this->post_id?>"><?=count($this->comments_iterator)?></span>)</span>
</div>
<div  class="comments-list hide">

	<div id="comments-list-<?=$this->post_id?>">
		<?php
			foreach ($this->comments_iterator as $comment){
				View::create('comment.php')->assign('data', $comment)->render();
			}
		?>
	</div>

	<hr/>
	<div style="padding-left: 30px">
		<?php View::create('form.php')
			->assign('action', 'addComment')
			->assign('post_id', $this->post_id)
			->assign('container_id', 'comments-list-'.$this->post_id)
			->render(); ?>
	</div>
</div>