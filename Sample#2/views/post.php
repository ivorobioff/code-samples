<h5><a href="mailto:<?=View::escape($this->data['email'])?>"><?=View::escape($this->data['name'])?></a> posted on
	<?=(new DateTime($this->data['insert_date']))->format('d-m-Y')?>:</h5>
<div class="post-block">
	<div class="post-message"><?=View::formatText(View::escape($this->data['message']))?></div>
</div>

<?php
View::create('comments-list.php')
	->assign('post_id', $this->data['id'])
	->assign('comments_iterator', $this->data['comments'])
	->render();
?>