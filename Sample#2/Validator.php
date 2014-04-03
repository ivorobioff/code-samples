<?php

/**
 * Igor Vorobiov<igor.vorobioff@gmail.com> 
 */
class Validator 
{
	private $_data;

	public function __construct(array $data)
	{
		$this->_data = $data;
	}

	public function validate()
	{
		if (trim($this->_data['name']) == '')
		{
			throw new ValidationFail('Enter your name');
		}

		if (!isset($this->_data['email']) || trim($this->_data['email']) == '')
		{
			throw new ValidationFail('Enter your email');
		}

		if (!preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', $this->_data['email']))
		{
			throw new ValidationFail('Wrong email format');
		}

		if (trim($this->_data['message']) == '') throw new ValidationFail('Message cant be empty');
		if (strlen($this->_data['message']) > 500) throw new ValidationFail('Message max length 500');

		if (trim($this->_data['captcha']) == '') throw new ValidationFail('Enter CAPTCHA');
		if ($this->_data['captcha'] != array_sum(Captcha::get())) throw new ValidationFail('Enter correct CAPTCHA');
	}

	public function validateComment()
	{
		$this->validate();

		if (!isset($this->_data['post_id']) || intval($this->_data['post_id']) == 0)
		{
			throw new ValidationFail('The comment can\'t be created');
		}
	}
} 