<?php 
class Models_User extends Models_Base{

	protected $_tableName = 'users';

	// Object
	public $facebook_id;
	public $status;

	// Status
	public $active;
	public $blocked;

	public function __construct() 
	{
		parent::__construct();
		$this->active = getConfig('active', ['value' => 1, 'text' => 'Active']);
	}

	public function checkAccountFB($facebook_id)
	{
		$sql = "SELECT * FROM ".$this->_tableName." WHERE facebook_id = '$facebook_id' AND del_flag = ".$this->del_flag['not_delete'];
		$result = $this->_connect->execute($sql); 
		return ($result->num_rows == 0) ? false : true;
	}

	// Check status 
	public function checkStatus($facebook_id) 
	{
		$sql = "SELECT * FROM ".$this->_tableName." WHERE facebook_id = '$facebook_id' AND del_flag = 0 AND status = ?".$this->active['value'];
				$result = $this->_connect->execute($sql);
		return ($result->num_rows == 0) ? false : true;
	}
}
