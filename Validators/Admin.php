<?php 
/**
 * 
 */
class Validators_Admin extends Validators_Base
{
	protected $_errors = [];

	public function checkPasswordConfirmation ($password, $password_confirmation) {
		if (strcmp($password, $password_confirmation) != 0) $this->addError('password_confirmation', "Those password didn't match. Try again.");
		return (!empty($this->_errors)) ? false : true;
	}

	public function requiredAdmin ($data = []) {
		foreach ($data as $k => $v) {
			if ($this->required($v)) $this->addError($k, ucfirst($k). " can't be blank.");
		}
		return (!empty($this->_errors)) ? false : true;
	}

	public function checkPasswordSize($password) {
		if (strlen($password) < 6) $this->addError('size_password', "Minimum password length is 6.");
		return (!empty($this->_errors)) ? false : true;
	}
}

?>