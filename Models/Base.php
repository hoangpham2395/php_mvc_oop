<?php 
class Models_Base {
	protected $_tableName = '';
	protected $_connect;

	public $id;
	public $name;
	public $email;
	public $ins_id;
	public $upd_id;
	public $ins_datetime;
	public $upd_datetime;
	public $del_flag;

	public function __construct()
	{
		$this->_connect = new Models_Connect();

		$this->del_flag = getConfig('del_flag', ['not_delete' => 0, 'deleted' => 1]);
	}

	// Get data
	public function getList() 
	{
		$sql = "SELECT * FROM ".$this->_tableName." WHERE del_flag = ".$this->del_flag['not_delete']; 
		return $this->fetchAll($sql);
	}

	// Search (none pagination)
	public function search($term = []) 
	{
		$sql = "SELECT * FROM ".$this->_tableName." WHERE del_flag = ".$this->del_flag['not_delete'];
		if (!empty($term['name'])) $sql .= " AND name like '".$term['name']."'";
		if (!empty($term['email'])) $sql .= " AND name like '".$term['email']."'";
		return $this->fetchAll($sql);
	}

	public function find($id) 
	{
		$sql = 'SELECT * FROM '. $this->_tableName.' WHERE id = '. $id.' AND del_flag = '.$this->del_flag['not_delete'];
		return $this->fetchOne($sql);
	}

	public function create($data = []) 
	{	
		$rows = ''; $values = '';
		foreach ($data as $key => $value) {
			$rows .= $key.', ';
			$values .= "'".$value."', ";
		}	
		$sql = "INSERT INTO ".$this->_tableName." (".$rows." ins_id, ins_datetime, upd_id, upd_datetime, del_flag) VALUES (".$values." '".$_SESSION['admin_user']['id']."', '".date('Y-m-d H:i:s')."', '".$_SESSION['admin_user']['id']."', '".date('Y-m-d H:i:s')."', ".$this->del_flag['not_delete'].")";
		
		$result = $this->_connect->execute($sql);
		return ($result) ? true : false;
	}

	public function update($id, $data = []) 
	{
		$update = '';
		foreach ($data as $key => $value) {
			$update .= $key."='".$value."', ";
		}
		$sql = "UPDATE ".$this->_tableName." SET ".$update." upd_id = '".$_SESSION['admin_user']['id']."', upd_datetime = '".date('Y-m-d H:i:s')."' WHERE id = '".$id."'";
		
		$result = $this->_connect->execute($sql);
		return ($result) ? true : false;
	}

	public function delete($id) 
	{
		$sql = "UPDATE ".$this->_tableName." SET del_flag = ".$this->del_flag['deleted'].", upd_id='".$_SESSION['admin_user']['id']."', upd_datetime='".date('Y-m-d H:i:s')."' WHERE id = '".$id."'";
		return ($this->_connect->execute($sql)) ? true : false;
	}

	// Get first data
	public function fetchOne($sql)
	{
		$result = $this->_connect->execute($sql);
		if (!$result) {
			return null;	
		}
		return mysqli_fetch_assoc($result);
	}

	// Get all data
	public function fetchAll($sql) 
	{	
		$result = $this->_connect->execute($sql);
		$list = [];
		while ($row =mysqli_fetch_assoc($result)) {
		  $list[] = $row;
		}
		return $list;
	}

	public function uniqueEditEmail($id, $email) 
	{
		$sql = "SELECT * FROM ".$this->_tableName." WHERE email = '".$email."' AND id <> '".$id."' AND del_flag = ".$this->del_flag['not_delete'];
		$result = $this->fetchOne($sql);
		return ($result) ? false : true;
	}

	// pagination (get data) 
	public function paginate($limit, $start, $row, $arrange) 
	{
		$sql = "SELECT * FROM ".$this->_tableName." WHERE del_flag = ".$this->del_flag['not_delete']." ORDER BY ".$row." ".$arrange." LIMIT ".$start.",".$limit;
		return $this->fetchAll($sql);
	}

	public function searchPaginate($term = [], $limit, $start, $row, $arrange) 
	{
		$sql = "SELECT * FROM ".$this->_tableName." WHERE del_flag = 0 ";
		if (!empty($term['name'])) $sql .= " AND name like '".$term['name']."'";
		if (!empty($term['email'])) $sql .= " AND email like '".$term['email']."'";
		$sql .= " ORDER BY ".$row." ".$arrange." LIMIT ".$start.",".$limit;
		return $this->fetchAll($sql);
	}
}
