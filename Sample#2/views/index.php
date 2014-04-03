<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta charset="utf-8">
	<title>Blogs</title>
	<link rel="stylesheet" type="text/css" href="/themes/site.css" />
	<script type="text/javascript" src="/themes/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="/themes/site.js"></script>
</head>
<body>
<div class="header-background"></div>
<div class="main-content">
	<div class="header">Blogs</div>
	<div class="content">
		<h2 class="posts-title">Posts</h2>
		<div class="post-list">
			<div id="posts-holder">
				<?php
					foreach ($this->posts_iterator as $post)
					{
						View::create('post.php')->assign('data', $post)->render();
					}
				?>
			</div>
			<h3>Your Post:</h3>
			<hr/>
			<?php View::create('form.php')
				->assign('action', 'addPost')
				->assign('container_id', 'posts-holder')
				->render(); ?>
		</div>
	</div>
	<div class="footer">Blogs <?=(new \DateTime())->format('Y')?></div>
</div>
</body>
</html>