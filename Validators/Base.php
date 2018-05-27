<?php 
class Validators_Base {
	protected $_errors = [];

	public function addError($field, $messages){
			$this->_errors[$field] = $messages;
			return $this;
	}

	public function required($field) {
		return (empty(trim($field))) ? true : false;
	}

	public function checkLengthName($name) {
		$result = (strlen(trim($name)) < 51) ? true : false;
		if (!$result) $this->addError('checkLengthName', "Maximum name length is 50.");
		return $result;
	}

	public function checkImage($type) {
		$result = ($type == 'jpg' || $type == 'jpeg' || $type == 'png' || $type == 'gif') ? true : false;
		if (!$result) $this->addError('checkImage', 'Sorry, only JPG, JPEG, PNG, GIF are allowed.');
		return $result;
	}

	public function checkFileSize($size) {
		$result = ($size < 1048576) ? true : false;
		if (!$result) $this->addError('checkFileSize', 'Sorry, your file is too large. File must less than 1MB.');
		return $result;
	}

	public function errors(){
			return $this->_errors;
	}
}
