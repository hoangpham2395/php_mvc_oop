<?php 
class Validators_User extends Validators_Base {
	protected $_errors = [];

	public function requiredUser ($data = []) {		
		foreach ($data as $k => $v) {
			if ($this->required($v)) $this->addError($k, ucfirst($k)." can't be blank.");
		}
		return (!empty($this->_errors)) ? false : true;
	}
}