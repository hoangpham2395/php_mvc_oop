<?php 
class Models_Admin extends Models_Base 
{
	protected $_tableName = "admin";
	
	// Object
	private $password;
	private $avatar;
	public $role_type;

	// Check login Admin
	public function checkLogin($email, $password) {
		$sql = "SELECT * FROM ". $this->_tableName ." WHERE email = '". $email."' and password = '". $password."' AND del_flag = ".$this->del_flag['not_delete'];
		$result = $this->fetchOne($sql);
		return $result;
	}

	// Check unique email
	public function uniqueEmail ($email) {
		$sql = "SELECT * FROM ".$this->_tableName." WHERE email = '".$email."' AND del_flag = ".$this->del_flag['not_delete'];
		$result = $this->fetchOne($sql);
		return ($result) ? false : true;
	}
	
	public function findSuperAdmin () {$this->del_flag['not_delete'];
		$result = $this->fetchOne($sql);
		return $result;
	}
}
