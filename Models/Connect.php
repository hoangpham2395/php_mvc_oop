<?php 
/**
 * Connect MySQL 
 */
class Models_Connect
{	
	protected $db_host; 
	protected $db_username;
	protected $db_password;
	protected $db_name;

	public $conn;

	public function __construct() {
		$this->db_host = getConfig('db_host', 'localhost'); 
		$this->db_username = getConfig('db_username', 'root');
		$this->db_password = getConfig('db_password', '');
		$this->db_name = getConfig('db_name', 'training');
	}
	
	public function getConnection() {
		$this->conn = new mysqli($this->db_host, $this->db_username, $this->db_password, $this->db_name);
		if ($this->conn->connect_error) {
			die("Connect failed: ".$this->conn->connect_error);
		}
		return $this->conn;
	}

	public function execute ($sql) {
		$this->getConnection();
		return $this->conn->query($sql);
	}

	public function close() {
		return $this->conn->close();
	}
}
?>