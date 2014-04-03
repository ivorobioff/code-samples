<div class="comment">
	<div class="comment-sender"><a href="mailto:<?=View::escape($this->data['email'])?>"><?=View::escape($this->data['name'])?></a> commented on
		<?=(new DateTime($this->data['insert_date']))->format('d-m-Y H:i')?></div>
	<div class="comment-message"><?=View::formatText(View::escape($this->data['message']))?></div>
</div>