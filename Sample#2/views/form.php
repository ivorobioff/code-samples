<form action="/?a=<?=$this->action?>" data-container-id="<?=$this->container_id?>">
<div class="post-form">
	<div class="f-label">Name:</div>
	<div class="f-input">
		<input type="text" name="name" maxlength="100" />
	</div>
	<div class="f-label">Email:</div>
	<div class="f-input">
		<input type="text" name="email" maxlength="100" />
	</div>
	<div class="f-label">Message:</div>
	<div class="f-input">
		<textarea name="message"></textarea>
	</div>
	<div class="f-label">
		Please prove that you are a human!<br/>
		<span class="expession">What is <?=$this->captcha[0]?> + <?=$this->captcha[1]?> = ?</span>
	</div>
	<div class="f-input">
		<input type="text" name="captcha"/>
	</div>
	<?php
		if (isset($this->post_id)){
		?>
			<input type="hidden" value="<?=$this->post_id?>" name="post_id" />
		<?php
		}
	?>

	<div class="">
		<input type="button" value="Post" onclick="post_message(this)"/>
	</div>
</div>
</form>