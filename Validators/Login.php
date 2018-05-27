<?php 
/**
 * 
 */
class Validators_Login extends Validators_Base
{
	protected $_errors = [];

	public function validate ($data) {
		if ($this->required($data['email'])) $this->addError('email', "Email can't be blank.");
		if ($this->required($data['password'])) $this->addError('password', "Password can't be blank.");

		return (empty($this->_errors)) ? true : false;
	}
}

?>
